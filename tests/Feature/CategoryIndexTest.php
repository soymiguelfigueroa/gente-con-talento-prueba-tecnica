<?php

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows categories and navigation links', function () {
    $firstCategory = Category::factory()->create(['name' => 'Arte']);
    $secondCategory = Category::factory()->create(['name' => 'Historia']);

    $response = $this->get('/categories');

    $response->assertOk()
        ->assertSee('Listado de categorías')
        ->assertSee($firstCategory->name)
        ->assertSee($secondCategory->name)
        ->assertSee('href="'.url('/books').'"', false)
        ->assertSee('href="'.url('/categories').'"', false);
});

it('shows validation messages when storing a duplicate category', function () {
    Category::factory()->create(['name' => 'Arte']);

    $this->from('/categories/create')->followingRedirects()->post('/categories', [
        'name' => 'Arte',
    ])
        ->assertOk()
        ->assertSeeText('The name has already been taken.');
});

it('shows validation messages when updating a category to a duplicate name', function () {
    $category = Category::factory()->create(['name' => 'Arte']);
    Category::factory()->create(['name' => 'Historia']);

    $this->from('/categories/'.$category->id.'/edit')->followingRedirects()->put('/categories/'.$category->id, [
        'name' => 'Historia',
    ])
        ->assertOk()
        ->assertSeeText('The name has already been taken.');
});

it('flashes and displays a message when creating a category', function () {
    $response = $this->post('/categories', [
        'name' => 'Ciencia',
    ]);

    $response->assertRedirect('/categories')
        ->assertSessionHas('success', 'La categoría se creó correctamente.');

    $this->get('/categories')
        ->assertOk()
        ->assertSeeText('La categoría se creó correctamente.');

    $this->assertDatabaseHas('categories', ['name' => 'Ciencia']);
});

it('flashes and displays a message when updating a category', function () {
    $category = Category::factory()->create(['name' => 'Arte']);

    $response = $this->put('/categories/'.$category->id, [
        'name' => 'Ciencia',
    ]);

    $response->assertRedirect('/categories')
        ->assertSessionHas('success', 'La categoría se actualizó correctamente.');

    $this->get('/categories')
        ->assertOk()
        ->assertSeeText('La categoría se actualizó correctamente.');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Ciencia',
    ]);
});

it('flashes and displays a message when deleting a category', function () {
    $category = Category::factory()->create();

    $response = $this->delete('/categories/'.$category->id);

    $response->assertRedirect('/categories')
        ->assertSessionHas('success', 'La categoría se eliminó correctamente.');

    $this->get('/categories')
        ->assertOk()
        ->assertSeeText('La categoría se eliminó correctamente.');

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});

it('flashes and displays the validation message when deleting a category with books', function () {
    $category = Category::factory()->create();
    $book = Book::factory()->create(['category_id' => $category->id]);

    $response = $this->from('/categories')->delete('/categories/'.$category->id);

    $response->assertRedirect('/categories')
        ->assertSessionHas('error', 'No se puede eliminar una categoría que tiene libros asociados.');

    $this->get('/categories')
        ->assertOk()
        ->assertSeeText('No se puede eliminar una categoría que tiene libros asociados.');

    $this->assertDatabaseHas('categories', ['id' => $category->id]);
    $this->assertDatabaseHas('books', ['id' => $book->id]);
});
