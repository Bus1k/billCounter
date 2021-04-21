<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryRepository
{
    private Category $categoryModel;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }

    public function all()
    {
        return $this->categoryModel->all();
    }

    public function create(string $name, int $description)
    {
        return $this->categoryModel->create([
            'user_id'     => Auth::id(),
            'name'        => $name,
            'description' => $description,
        ]);
    }

    public function edit(Category $category, string $name, int $description)
    {
        $category->update([
            'name'        => $name,
            'description' => $description,
        ]);
    }

    public function delete(Category $category)
    {
        $category->delete();
    }
}
