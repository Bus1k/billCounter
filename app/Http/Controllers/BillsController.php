<?php
namespace App\Http\Controllers;

use App\Models\Bill;
use App\Repositories\BillRepository;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    private BillRepository $repository;

    public function __construct(BillRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    public function index()
    {
        return view('bills.bills', [
            'bills' => $this->repository->all()
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
        $rules = [
            'description' => 'required|string|min:3|max:50',
            'type'        => 'required|string|min:3|max:50',
            'amount'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ];
        $request->validate($rules);

        $this->repository->create(
            $request->description,
            $request->type,
            $request->amount,
            'filename',
            'filelocation'
        );

        return redirect('/bills');
    }

    public function edit(Bill $bill)
    {
        return view('bills.edit', [
            'bill' => $bill
        ]);
    }

    public function update(Request $request, Bill $bill)
    {
        $rules = [
            'description' => 'required|string|min:3|max:50',
            'type'        => 'required|string|min:3|max:50',
            'amount'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ];
        $request->validate($rules);

        $this->repository->edit(
            $bill,
            $request->description,
            $request->type,
            $request->amount,
            'filename',
            'filelocation'
        );

        return redirect('/bills');
    }

    public function destroy(Bill $bill)
    {

    }
}
