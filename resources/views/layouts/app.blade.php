<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- 1. Tambahkan Script Chart.js di sini --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-100">

        <div class="fixed top-0 left-0 w-64 h-full z-20">
            @include('layouts.sidebar')
        </div>

        <div class="flex-1 flex flex-col w-full pl-64">

            <div class="sticky top-0 z-10">
                @include('layouts.navigation')

                @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                @endif
            </div>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-gray-100">
                {{ $slot }}
            </main>

        </div>
    </div>

    {{-- 2. Tambahkan "wadah" untuk script kita di sini, sebelum body berakhir --}}
    @stack('scripts')
</body>

</html>