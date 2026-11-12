@extends('layouts.books')

@section('title', 'Editar libro')
@section('heading', 'Editar libro')

@section('content')
    <form action="{{ url('/books/'.$book->id) }}" method="POST" class="max-w-2xl space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-1">
            <label for="title" class="text-sm font-medium text-gray-700">Título</label>
            <input
                id="title"
                name="title"
                type="text"
                value="{{ old('title', $book->title) }}"
                required
                class="rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >
            @error('title')
                <p class="text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1">
            <label for="author" class="text-sm font-medium text-gray-700">Autor</label>
            <input
                id="author"
                name="author"
                type="text"
                value="{{ old('author', $book->author) }}"
                required
                class="rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >
            @error('author')
                <p class="text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1">
            <label for="description" class="text-sm font-medium text-gray-700">Descripción</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >{{ old('description', $book->description) }}</textarea>
            @error('description')
                <p class="text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1">
            <label for="published_year" class="text-sm font-medium text-gray-700">Año de publicación</label>
            <input
                id="published_year"
                name="published_year"
                type="number"
                value="{{ old('published_year', $book->published_year) }}"
                required
                class="rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >
            @error('published_year')
                <p class="text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1">
            <label for="category_id" class="text-sm font-medium text-gray-700">Categoría</label>
            <select
                id="category_id"
                name="category_id"
                required
                class="rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >
                <option value="">Selecciona una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $book->category_id) === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-sm text-red-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Guardar cambios
            </button>
            <a href="{{ url('/books') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
        </div>
    </form>
@endsection
