<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

        return redirect('/categories')->with('success', 'La categoría se creó correctamente.');
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

        return redirect('/categories')->with('success', 'La categoría se actualizó correctamente.');
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->destroyCategory($id);
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->errors()['category_id'][0]);
        }

        return redirect('/categories')->with('success', 'La categoría se eliminó correctamente.');
    }
}
