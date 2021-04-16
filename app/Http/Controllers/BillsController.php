<?php
namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Repositories\BillRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\MonthsHelper;

class BillsController extends Controller
{
    private const RULES = [
        'description' => 'required|string|min:3|max:50',
        'type'        => 'required|string|min:3|max:50',
        'amount'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'photo'       => 'nullable|mimes:jpg,jpeg,png'
    ];

    private BillRepository $repository;

    public function __construct(BillRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }


    public function index()
    {
        $bills = $this->repository->allByMonth(now()->month);

        $currentMonthSum = 0;
        $currentMonthQuantity = 0;

        foreach($bills as $bill){
            $currentMonthSum += (float)$bill['amount'];
            $currentMonthQuantity++;
        }

        return view('bills.bills', [
            'bills' => $bills,
            'monthName' => MonthsHelper::getCurrentMonthName(now()->month),
            'stats' => [
                'currentMonthSum' => $currentMonthSum,
                'currentMonthQuantity' => $currentMonthQuantity
            ]
        ]);
    }


    public function show(Bill $bill)
    {
        return $bill;
    }


    public function create()
    {
        return view('bills.create');
    }


    public function store(Request $request)
    {
        $request->validate(self::RULES);

        $filename = null;
        if($request->hasFile('photo'))
        {
            $request->file('photo')->store('public/bills/', 'local');
            $filename = $request->file('photo')->hashName();
        }

        $this->repository->create(
            $request->description,
            $request->type,
            $request->amount,
            $filename,
        );

        return redirect(route('index_bill'));
    }


    public function edit(Bill $bill)
    {
        return view('bills.edit', [
            'bill' => $bill
        ]);
    }


    public function update(Request $request, Bill $bill)
    {
        $request->validate(self::RULES);

        $this->repository->edit(
            $bill,
            $request->description,
            $request->type,
            $request->amount,
            'filename',
        );

        return redirect(route('index_bill'));
    }


    public function destroy(Bill $bill)
    {
        $this->repository->delete($bill);

        return redirect(route('index_bill'));
    }


    public function ajax()
    {
        if($_POST['table_type'] === 'billTable'){

            $date = Carbon::create($_POST['selected_date']);
            $bills = $this->repository->allByMonth($date->month);

            $out = [
                'data' => []
            ];

            foreach($bills as $bill) {

                $photo = null;
                if($bill['photo_name']) {
                    $photo = '<a target="_blank" href="'. url("storage/bills/" . $bill["photo_name"]) .'">
                                    <button type="button" class="btn btn-success">
                                        <i class="fas fa-file-image"></i>
                                    </button>
                                </a>';
                }

                $actions = '
                    <a href="'. route('edit_bill', $bill["id"]) .'" class="btn btn-primary"><i class="far fa-edit"></i></a>
                    <a href="'. route('delete_bill', $bill["id"]) .'" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                ';

                $out['data'][] = [
                    $bill['id'],
                    User::find($bill['user_id'])->name,
                    $bill['description'],
                    $bill['type'],
                    $bill['amount'],
                    $photo,
                    $bill['created_at']->format('Y-m-d H:i:s'),
                    $bill['updated_at']->format('Y-m-d H:i:s'),
                    $actions
                ];
            }

            $currentMonthSum = 0;
            $currentMonthQuantity = 0;

            foreach($bills as $bill){
                $currentMonthSum += (float)$bill['amount'];
                $currentMonthQuantity++;
            }

            $out['additional'] = [
                'monthName' => MonthsHelper::getCurrentMonthName($date->month),
                'currentMonthSum' => $currentMonthSum,
                'currentMonthQuantity' => $currentMonthQuantity
            ];

            return response()->json($out);
        }
    }
}
