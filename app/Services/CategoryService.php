<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Validation\ValidationException;

class CategoryService
{
    public function getCategories()
    {
        return Category::all();
    }

    public function storeCategory($data)
    {
        Category::create($data);
    }

    public function updateCategory($id, $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        // Verificar que una categoría no tenga libros asociados antes de permitir su eliminación
        if ($category->books()->exists()) {
            throw ValidationException::withMessages([
                'category_id' => 'No se puede eliminar una categoría que tiene libros asociados.',
            ]);
        }

        $category->delete();
    }
}
