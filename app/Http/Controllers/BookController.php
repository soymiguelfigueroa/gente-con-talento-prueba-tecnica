<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Category;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {}

    public function index(Request $request)
    {
        $categoryId = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ])['category_id'] ?? null;
        $books = $this->bookService->getAvailableBooks($categoryId);
        $categories = Category::query()->orderBy('name')->get();

        return view('books.index', compact('books', 'categories', 'categoryId'));
    }

    public function create(Request $request)
    {
        $categories = Category::all();

        return view('books.create', compact('categories'));
    }

    public function store(BookRequest $request)
    {
        $data = $request->validated();
        $book = $this->bookService->storeBook($data);

        $books = $this->bookService->getAvailableBooks();
        $categories = Category::query()->orderBy('name')->get();
        $categoryId = null;

        return view('books.index', compact('books', 'categories', 'categoryId'));
    }

    public function edit($id)
    {
        $book = $this->bookService->getAvailableBooks()->find($id);
        $categories = Category::all();

        return view('books.edit', compact('book', 'categories'));
    }

    public function update(BookRequest $request, $id)
    {
        $data = $request->validated();
        $book = $this->bookService->updateBook($id, $data);

        $books = $this->bookService->getAvailableBooks();
        $categories = Category::query()->orderBy('name')->get();
        $categoryId = null;

        return view('books.index', compact('books', 'categories', 'categoryId'));
    }

    public function destroy($id)
    {
        $this->bookService->destroyBook($id);

        $books = $this->bookService->getAvailableBooks();
        $categories = Category::query()->orderBy('name')->get();
        $categoryId = null;

        return view('books.index', compact('books', 'categories', 'categoryId'));
    }
}
