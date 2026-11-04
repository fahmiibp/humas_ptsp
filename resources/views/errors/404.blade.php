<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Halaman Tidak Ditemukan | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col bg-white text-gray-800 antialiased">

    {{-- Bar sederhana --}}
    <header class="border-b border-gray-100">
        <div class="mx-auto flex h-16 max-w-6xl items-center px-4">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('image/ptsp.png') }}" width="100" alt="Logo">
                <span class="font-mono text-3xl font-bold text-teal-700">News</span>
            </a>
        </div>
    </header>

    <main class="flex flex-1 items-center justify-center px-4 py-16">
        <div class="w-full max-w-xl text-center">

            <div class="flex items-center justify-center text-gray-500">
                <span class="border-r border-gray-400 px-4 text-lg tracking-wider">404</span>
                <span class="px-4 text-lg uppercase tracking-wider">Page not found</span>
            </div>

            <p class="mt-3 text-sm leading-relaxed text-gray-500">
                Tautan mungkin salah, atau berita sudah dipindahkan atau dihapus.
                Coba cari berita lain atau kembali ke beranda.
            </p>

            {{-- Pencarian --}}
            <form action="{{ url('/') }}" method="GET" class="mx-auto mt-8 flex max-w-md gap-2">
                <input type="search" name="search" placeholder="Cari berita..."
                    class="min-w-0 flex-1 rounded-full border border-gray-300 px-4 py-2 text-sm focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500">
                <button type="submit"
                    class="rounded-full bg-teal-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-teal-700">
                    Cari
                </button>
            </form>

            {{-- Tombol --}}
            <div class="mt-6 flex justify-center">
                <a href="{{ url('/') }}"
                    class="text-sm uppercase tracking-wider text-gray-500 underline underline-offset-4 transition hover:text-gray-700">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    <footer class="border-t border-gray-100 py-4 text-center text-xs text-gray-400">
        © {{ date('Y') }} {{ config('app.name') }}. Hak cipta dilindungi.
    </footer>
</body>

</html>
