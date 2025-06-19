<x-head>
    <!-- Sidebar -->
    <div id="sidebar" class=" hidden">
        <div class="sidebar-header">
            <span class="close-btn" onclick="toggleMenu()">&times;</span>
            <h2>Beautyworks by Fifi</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}">Dashboard</a></li>
{{--            <li><a href="{{ route('about') }}">Tentang Kami</a></li>--}}
            <li class="has-submenu">
                <a href="#" onclick="toggleSubmenu(event)">
                    Portfolio
                    <span class="chevron">&#9662;</span> <!-- Unicode for ▼ -->
                </a>
                <ul class="submenu hidden">
{{--                    <li><a href="{{ route('portfolio.team') }}">Make up Team</a></li>--}}
{{--                    <li><a href="{{ route('portfolio.wedding') }}">Make Up Wedding</a></li>--}}
{{--                    <li><a href="{{ route('portfolio.event') }}">Make Up Events</a></li>--}}
{{--                    <li><a href="{{ route('portfolio.class') }}">Make Up Class</a></li>--}}
                </ul>
            </li>
{{--            <li><a href="{{ route('terms') }}">Syarat & Ketentuan</a></li>--}}
{{--            <li><a href="{{ route('services') }}">Layanan Kami</a></li>--}}
{{--            <li><a href="{{ route('testimonials') }}">Testimoni</a></li>--}}
{{--            <li><a href="{{ route('contact') }}">Hubungi Kami</a></li>--}}
{{--            <li><a href="{{ route('login') }}">Masuk</a></li>--}}
        </ul>
    </div>

    <!-- Navbar -->
    <header>
        <div class="navbar">
            <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
            <div class="logo">Beautyworks by Fifi</div>
            <div class="logo-image">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>
</x-head>
