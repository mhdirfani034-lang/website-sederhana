<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ruang Kampus') — Ruang Kampus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}" aria-label="Ruang Kampus, beranda">
            <span class="brand-mark">rk<span>.</span></span>
            <span class="brand-name">ruang<span>kampus</span></span>
        </a>
        <nav class="main-nav" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')])>Beranda</a>
            <a href="{{ route('mahasiswa.index') }}" @class(['is-active' => request()->routeIs('mahasiswa.*')])>Data mahasiswa</a>
        </nav>
        <a class="header-cta" href="{{ route('mahasiswa.index') }}">
            Kelola data
            <span aria-hidden="true">↗</span>
        </a>
    </header>

    <main>
        @if (session('success'))
            <div class="toast-message" role="status">
                <span class="toast-check" aria-hidden="true">✓</span>
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <a class="brand brand-small" href="{{ route('home') }}">
            <span class="brand-mark">rk<span>.</span></span>
            <span class="brand-name">ruang<span>kampus</span></span>
        </a>
        <p>Ruang yang lebih rapi untuk data kampus.</p>
        <span>© {{ date('Y') }} Ruang Kampus</span>
    </footer>

    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
