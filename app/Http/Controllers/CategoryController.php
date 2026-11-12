<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->getCategories();

        return view('categories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $this->categoryService->storeCategory($data);

        $categories = $this->categoryService->getCategories();

        return view('categories.index', compact('categories'));
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategories()->find($id);

        return view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->validated();
        $this->categoryService->updateCategory($id, $data);

        $categories = $this->categoryService->getCategories();

        return view('categories.index', compact('categories'));
    }

    public function destroy($id)
    {
        $this->categoryService->destroyCategory($id);

        $categories = $this->categoryService->getCategories();

        return view('categories.index', compact('categories'));
    }
}
