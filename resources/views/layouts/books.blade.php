<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestión de libros')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 p-6 text-gray-900">
    <main class="mx-auto max-w-7xl">
        <nav aria-label="Navegación principal" class="mb-6 flex flex-wrap gap-2">
            <a
                href="{{ url('/books') }}"
                @class([
                    'rounded-md border px-4 py-2 text-sm font-medium',
                    'border-indigo-600 bg-indigo-50 text-indigo-700' => request()->is('books*'),
                    'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' => ! request()->is('books*'),
                ])
                @if (request()->is('books*')) aria-current="page" @endif
            >
                Libros
            </a>
            <a
                href="{{ url('/categories') }}"
                @class([
                    'rounded-md border px-4 py-2 text-sm font-medium',
                    'border-indigo-600 bg-indigo-50 text-indigo-700' => request()->is('categories*'),
                    'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' => ! request()->is('categories*'),
                ])
                @if (request()->is('categories*')) aria-current="page" @endif
            >
                Categorías
            </a>
        </nav>

        <header class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold">@yield('heading')</h1>
            @yield('actions')
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-md border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="status" aria-live="polite">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert" aria-live="assertive">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
