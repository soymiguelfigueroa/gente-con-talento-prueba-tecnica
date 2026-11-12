@extends('layouts.books')

@section('title', 'Registrar categoría')
@section('heading', 'Registrar categoría')

@section('content')
    <form action="{{ url('/categories') }}" method="POST" class="max-w-2xl space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        @csrf

        <div class="flex flex-col gap-1">
            <label for="name" class="text-sm font-medium text-gray-700">Nombre</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
                class="rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
            >
        </div>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Registrar categoría
            </button>
            <a href="{{ url('/categories') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancelar
            </a>
        </div>
    </form>
@endsection
