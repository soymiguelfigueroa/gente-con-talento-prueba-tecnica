@extends('layouts.books')

@section('title', 'Listado de categorías')
@section('heading', 'Listado de categorías')

@section('actions')
    <a
        href="{{ url('/categories/create') }}"
        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
    >
        Registrar categoría
    </a>
@endsection

@section('content')
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="w-full min-w-[400px] divide-y divide-gray-200 text-left text-sm">
            <thead class="bg-gray-100 text-xs uppercase tracking-wide text-gray-600">
                <tr>
                    <th scope="col" class="px-4 py-3">ID</th>
                    <th scope="col" class="px-4 py-3">Nombre</th>
                    <th scope="col" class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="whitespace-nowrap px-4 py-3">{{ $category->id }}</td>
                        <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                        <td class="whitespace-nowrap px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a
                                    href="{{ url('/categories/'.$category->id.'/edit') }}"
                                    class="rounded-md bg-amber-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-amber-600"
                                >
                                    Editar
                                </a>
                                <form
                                    action="{{ url('/categories/'.$category->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')"
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
                        <td colspan="2" class="px-4 py-8 text-center text-gray-500">
                            No hay categorías para mostrar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
