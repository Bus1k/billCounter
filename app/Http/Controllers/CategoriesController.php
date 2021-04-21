<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return view('categories.categories', [
            'categories' => $this->categoryRepository->all()
        ]);
    }
}
