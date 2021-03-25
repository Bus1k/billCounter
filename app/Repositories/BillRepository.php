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

    public function get(int $id)
    {
        return $this->billModel->where('id', $id)->first();
    }

    public function create(string $description, string $type, float $amount, string $fileName, string $location)
    {
        return $this->billModel->create([
            'user_id'     => Auth::id(),
            'description' => $description,
            'type'        => $type,
            'amount'      => $amount,
            'photo_name'  => $fileName,
            'photo_location' => $location
        ]);
    }

    public function edit(Bill $bill, string $description, string $type, float $amount,  string $fileName, string $location)
    {
        $bill->description = $description;
        $bill->type = $type;
        $bill->amount = $amount;
        $bill->photo_name = $fileName;
        $bill->photo_location = $location;
        $bill->save();
    }

    public function delete()
    {

    }


}
