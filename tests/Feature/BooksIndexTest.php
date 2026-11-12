<?php

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows only books from the selected category', function () {
    $selectedCategory = Category::factory()->create(['name' => 'Novela']);
    $otherCategory = Category::factory()->create(['name' => 'Historia']);

    $selectedBook = Book::factory()->create([
        'category_id' => $selectedCategory->id,
        'title' => 'Libro de novela',
    ]);
    Book::factory()->create([
        'category_id' => $otherCategory->id,
        'title' => 'Libro de historia',
    ]);

    $response = $this->get('/books?category_id='.$selectedCategory->id);

    $response->assertOk()
        ->assertSee('Libro de novela')
        ->assertDontSee('Libro de historia')
        ->assertSee('value="'.$selectedCategory->id.'" selected', false)
        ->assertSee('Historia')
        ->assertSee('href="'.url('/books').'"', false)
        ->assertSee('href="'.url('/categories').'"', false)
        ->assertSee('href="'.url('/books/'.$selectedBook->id.'/edit').'"', false)
        ->assertSee('action="'.url('/books/'.$selectedBook->id).'"', false)
        ->assertSee('name="_method" value="DELETE"', false)
        ->assertSee('type="submit"', false)
        ->assertSee('return confirm(', false);
});
