@extends('layouts.books')

@section('title', 'Listado de libros')
@section('heading', 'Listado de libros')

@section('actions')
    <a
        href="{{ url('/books/create') }}"
        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
    >
        Registrar libro
    </a>
@endsection

@section('content')
    <form action="{{ url('/books') }}" method="GET" class="mb-6 flex flex-wrap items-end gap-3">
        <div class="flex flex-col gap-1">
            <label for="category_id" class="text-sm font-medium text-gray-700">Filtrar por categoría</label>
            <select
                id="category_id"
                name="category_id"
                class="min-w-60 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >
                <option value="">Todas las categorías</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            Filtrar
        </button>
    </form>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="w-full min-w-[700px] divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-100 text-xs uppercase tracking-wide text-gray-600">
                <tr>
                    <th scope="col" class="px-4 py-3">ID</th>
                    <th scope="col" class="px-4 py-3">Título</th>
                    <th scope="col" class="px-4 py-3">Autor</th>
                    <th scope="col" class="px-4 py-3">Descripción</th>
                    <th scope="col" class="px-4 py-3">Año de publicación</th>
                    <th scope="col" class="px-4 py-3">Categoría</th>
                    <th scope="col" class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($books as $book)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-4 py-3">{{ $book->id }}</td>
                        <td class="px-4 py-3 font-medium">{{ $book->title }}</td>
                        <td class="px-4 py-3">{{ $book->author }}</td>
                        <td class="max-w-md px-4 py-3">{{ $book->description ?: 'Sin descripción' }}</td>
                        <td class="whitespace-nowrap px-4 py-3">{{ $book->published_year }}</td>
                        <td class="whitespace-nowrap px-4 py-3">{{ $book->category->name }}</td>
                        <td class="whitespace-nowrap px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a
                                    href="{{ url('/books/'.$book->id.'/edit') }}"
                                    class="rounded-md bg-amber-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-amber-600"
                                >
                                    Editar
                                </a>
                                <form
                                    action="{{ url('/books/'.$book->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este libro?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="rounded-md bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            No hay libros para mostrar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
