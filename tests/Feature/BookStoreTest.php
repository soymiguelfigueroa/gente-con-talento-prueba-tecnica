<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires all mandatory fields when storing a book', function () {
    $response = $this->post('/books', []);

    $response->assertSessionHasErrors(['title', 'author', 'published_year', 'category_id']);
    $this->assertDatabaseCount('books', 0);
});

it('rejects invalid book field values', function (array $invalidData, string $field) {
    $category = Category::factory()->create();
    $data = array_merge([
        'title' => 'A valid title',
        'author' => 'A valid author',
        'published_year' => '2024',
        'category_id' => $category->id,
    ], $invalidData);

    $response = $this->post('/books', $data);

    $response->assertSessionHasErrors([$field]);
    $this->assertDatabaseCount('books', 0);
})->with([
    'short title' => [['title' => 'AB'], 'title'],
    'non-numeric year' => [['published_year' => 'not a year'], 'published_year'],
    'year with fewer than four digits' => [['published_year' => '202'], 'published_year'],
    'zero year' => [['published_year' => '0000'], 'published_year'],
    'nonexistent category' => [['category_id' => 999999], 'category_id'],
]);

it('stores a book with valid data', function () {
    $category = Category::factory()->create();

    $response = $this->post('/books', [
        'title' => 'A valid title',
        'author' => 'A valid author',
        'description' => 'A valid description',
        'published_year' => '2024',
        'category_id' => $category->id,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('books', [
        'title' => 'A valid title',
        'author' => 'A valid author',
        'description' => 'A valid description',
        'published_year' => 2024,
        'category_id' => $category->id,
    ]);
});
