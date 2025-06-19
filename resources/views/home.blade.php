<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautyworks</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header class="flex items-center justify-between p4"> 
        <label class="btn btn-circle swap swap-rotate">
            <!-- this hidden checkbox controls the state -->
            <input type="checkbox" />

            <!-- hamburger icon -->
            <svg
                class="swap-off fill-current"
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 512 512">
                <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
            </svg>

            <!-- close icon -->
            <svg
                class="swap-on fill-current"
                xmlns="http://www.w3.org/2000/svg"
                width="32"
                height="32"
                viewBox="0 0 512 512">
                <polygon
                points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
            </svg>
        </label>
        <h1 class="font-bold text-2xl">Beautyworks by Fifi </h1> 
        <img class="w-[10%]" src="{{ asset('images/logo.png') }}" alt="Logo">   
    </header>
    
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <span class="close-btn" onclick="toggleMenu()">&times;</span>
            <h2>Beautyworks by Fifi</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}">Dashboard</a></li>
            <li><a href="">Tentang Kami</a></li>
            <li class="has-submenu">
                <a href="#" onclick="toggleSubmenu(event)">
                    Portfolio
                    <span class="chevron">&#9662;</span> <!-- Unicode for ▼ -->
                </a>
                <ul class="submenu hidden">
                    <li><a href="">Make up Team</a></li>
                    <li><a href="">Make Up Wedding</a></li>
                    <li><a href="">Make Up Events</a></li>
                    <li><a href="">Make Up Class</a></li>
                </ul>
            </li>
            <li><a href="">Syarat & Ketentuan</a></li>
            <li><a href="">Layanan Kami</a></li>
            <li><a href="">Testimoni</a></li>
            <li><a href="">Hubungi Kami</a></li>
            <li><a href="">Masuk</a></li>
        </ul>
    </div>
@vite('resources/js/app.js')
</body>
</html>
