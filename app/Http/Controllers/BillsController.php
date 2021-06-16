<?php
namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Category;
use App\Repositories\BillRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GroupRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\MonthsHelper;
use Illuminate\Support\Facades\Auth;

class BillsController extends Controller
{
    private const RULES = [
        'description' => 'required|string|min:3|max:50',
        'amount'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'photo'       => 'nullable|mimes:jpg,jpeg,png'
    ];

    private BillRepository $billRepository;
    private CategoryRepository $categoryRepository;
    private GroupRepository $groupRepository;

    public function __construct(BillRepository $billRepository, CategoryRepository $categoryRepository, GroupRepository $groupRepository)
    {
        $this->middleware('auth');
        $this->billRepository = $billRepository;
        $this->categoryRepository = $categoryRepository;
        $this->groupRepository = $groupRepository;
    }


    public function index()
    {
        $bills = $this->billRepository->allByMonth(now()->month);

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
        return view('bills.create', [
            'categories' => $this->categoryRepository->all(),
            'groups'     => $this->groupRepository->getGroupsByUserId(Auth::id())
        ]);
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

        $this->billRepository->create(
            $request->description,
            $request->category_id,
            $request->group_id,
            $request->amount,
            $filename,
        );

        return redirect(route('index_bill'))
            ->with('success', 'Bill added successfully');
    }


    public function edit(Bill $bill)
    {
        return view('bills.edit', [
            'bill' => $bill,
            'categories' => $this->categoryRepository->all()
        ]);
    }


    public function update(Request $request, Bill $bill)
    {
        $request->validate(self::RULES);

        $filename = $bill['photo_name'];
        if($request->hasFile('photo'))
        {
            $request->file('photo')->store('public/bills/', 'local');
            $filename = $request->file('photo')->hashName();
        }

        $this->billRepository->edit(
            $bill,
            $request->description,
            $request->category_id,
            $request->amount,
            $filename
        );

        return redirect(route('index_bill'))
            ->with('success', 'Bill updated successfully');
    }


    public function destroy(Bill $bill)
    {
        $this->billRepository->delete($bill);
        return redirect(route('index_bill'))
            ->with('success', 'Bill removed successfully');
    }


    public function ajax()
    {
        if($_POST['table_type'] === 'billTable'){

            $date = Carbon::create($_POST['selected_date']);
            $bills = $this->billRepository->allByMonth($date->month);

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
                    $bill->user->name,
                    $bill->group->name,
                    $bill->category->name,
                    $bill['description'],
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
