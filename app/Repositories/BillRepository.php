<?php
namespace App\Repositories;

use App\Models\Bill;
use Illuminate\Support\Facades\Auth;

class BillRepository
{
    private Bill $billModel;

    public function __construct(Bill $billModel)
    {
        $this->billModel = $billModel;
    }

    public function all()
    {
        return $this->billModel->get();
    }

    public function allByMonth(int $month)
    {
        return $this->billModel->whereMonth('created_at', $month)->get();
    }

    public function get(int $id)
    {
        return $this->billModel->where('id', $id)->first();
    }

    public function create(string $description, int $categoryId, float $amount, ?string $fileName = null)
    {
        return $this->billModel->create([
            'user_id'     => Auth::id(),
            'description' => $description,
            'category_id' => $categoryId,
            'amount'      => $amount,
            'photo_name'  => $fileName,
        ]);
    }

    public function edit(Bill $bill, string $description, int $categoryId, float $amount,  ?string $fileName)
    {
        $bill->update([
            'description' => $description,
            'category_id' => $categoryId,
            'amount'      => $amount,
            'photo_name'  => $fileName,
        ]);
    }

    public function delete(Bill $bill)
    {
        $bill->delete();
    }


}
