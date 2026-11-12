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
