<?php

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
