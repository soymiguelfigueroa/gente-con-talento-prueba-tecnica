<?php

use App\Models\Book;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

it('prevents deleting a category that has associated books', function () {
    $category = Category::factory()->create();
    $book = Book::factory()->for($category)->create();
    $categoryService = new CategoryService;
    $validationException = null;

    try {
        $categoryService->destroyCategory($category->id);
    } catch (ValidationException $exception) {
        $validationException = $exception;
    }

    expect($validationException)->toBeInstanceOf(ValidationException::class);
    expect($validationException->errors())->toBe([
        'category_id' => ['No se puede eliminar una categoría que tiene libros asociados.'],
    ]);

    $this->assertModelExists($category);
    $this->assertModelExists($book);
});

it('deletes a category that has no associated books', function () {
    $category = Category::factory()->create();
    $categoryService = new CategoryService;

    $categoryService->destroyCategory($category->id);

    $this->assertModelMissing($category);
});
