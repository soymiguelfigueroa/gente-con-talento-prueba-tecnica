<?php

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires all mandatory fields when storing a book', function () {
    $response = $this->post('/books', []);

    $response->assertSessionHasErrors(['title', 'author', 'published_year', 'category_id']);
    $this->assertDatabaseCount('books', 0);
});

it('shows validation messages when storing a book with invalid data', function () {
    $category = Category::factory()->create();

    $this->from('/books/create')->followingRedirects()->post('/books', [
        'title' => 'AB',
        'author' => 'A valid author',
        'published_year' => '2024',
        'category_id' => $category->id,
    ])
        ->assertOk()
        ->assertSeeText('The title field must be at least 3 characters.');
});

it('shows validation messages when updating a book with invalid data', function () {
    $book = Book::factory()->create();

    $this->from('/books/'.$book->id.'/edit')->followingRedirects()->put('/books/'.$book->id, [
        'title' => 'AB',
        'author' => $book->author,
        'description' => $book->description,
        'published_year' => $book->published_year,
        'category_id' => $book->category_id,
    ])
        ->assertOk()
        ->assertSeeText('The title field must be at least 3 characters.');
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

    $response->assertRedirect('/books')
        ->assertSessionHas('success', 'El libro se creó correctamente.');

    $this->get('/books')
        ->assertOk()
        ->assertSeeText('El libro se creó correctamente.');

    $this->assertDatabaseHas('books', [
        'title' => 'A valid title',
        'author' => 'A valid author',
        'description' => 'A valid description',
        'published_year' => 2024,
        'category_id' => $category->id,
    ]);
});

it('flashes and displays a message when updating a book', function () {
    $book = Book::factory()->create();
    $category = Category::factory()->create();

    $response = $this->put('/books/'.$book->id, [
        'title' => 'Updated title',
        'author' => 'Updated author',
        'description' => 'Updated description',
        'published_year' => '2024',
        'category_id' => $category->id,
    ]);

    $response->assertRedirect('/books')
        ->assertSessionHas('success', 'El libro se actualizó correctamente.');

    $this->get('/books')
        ->assertOk()
        ->assertSeeText('El libro se actualizó correctamente.');

    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'title' => 'Updated title',
        'author' => 'Updated author',
    ]);
});

it('flashes and displays a message when deleting a book', function () {
    $book = Book::factory()->create();

    $response = $this->delete('/books/'.$book->id);

    $response->assertRedirect('/books')
        ->assertSessionHas('success', 'El libro se eliminó correctamente.');

    $this->get('/books')
        ->assertOk()
        ->assertSeeText('El libro se eliminó correctamente.');

    $this->assertDatabaseMissing('books', ['id' => $book->id]);
});
