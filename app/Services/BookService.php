<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getAvailableBooks($categoryId = null)
    {
        $books = Book::with('category');

        if ($categoryId !== null) {
            $books->where('category_id', $categoryId);
        }

        return $books->get();
    }

    public function storeBook($data)
    {
        return Book::create($data);
    }

    public function updateBook($id, $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);

        return $book;
    }

    public function destroyBook($id)
    {
        $book = Book::findOrFail($id); // Verificar la existencia del libro antes de proceder con su eliminación.
        $book->delete();
    }
}
