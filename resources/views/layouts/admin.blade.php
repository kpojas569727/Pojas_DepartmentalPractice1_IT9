<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Plant Nursery')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="flex gap-6">
            <span class="font-bold">Plant Nursery</span>
            <a href="{{ route('plants.index') }}" class="text-gray-700 hover:underline">Plants</a>
            <a href="{{ route('reports.plants') }}" class="text-gray-700 hover:underline">Reports</a>
        </div>
        <div class="flex items-center gap-4">
            <span>{{ auth()->user()->name }}</span>
            {{-- Logout must be a POST form with CSRF --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-600">Logout</button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

</body>
</html>