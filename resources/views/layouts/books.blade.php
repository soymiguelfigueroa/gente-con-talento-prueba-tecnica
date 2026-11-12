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
        <header class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold">@yield('heading')</h1>
            @yield('actions')
        </header>

        @yield('content')
    </main>
</body>
</html>
