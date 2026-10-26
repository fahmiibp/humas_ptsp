<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'News - PTSP' }}</title>
    <link rel="icon" href="{{ asset('image/ptsp.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    <x-navbar />

    <main class="mx-auto max-w-6xl px-4 py-6">
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts
</body>

</html>
