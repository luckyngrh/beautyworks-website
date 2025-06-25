<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {{-- Tambahkan baris ini untuk CSRF token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Beautyworks by Fifi</title>
  @vite('resources/css/app.css')
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
</head>

<body>
  <div class="drawer">
    <input id="my-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
      <header class="flex items-center justify-between p4 px-7">
        <label for="my-drawer" class="btn btn-circle swap swap-rotate">
          <input type="checkbox" />

          <svg class="swap-off fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
            viewBox="0 0 512 512">
            <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
          </svg>

          <svg class="swap-on fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
            viewBox="0 0 512 512">
            <polygon
              points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
          </svg>
        </label>
        <h1 class="font-bold text-4xl font-allura">Beautyworks by Fifi </h1>
        <img class="w-[10%]" src="{{ asset('images/logo.png') }}" alt="Logo">
      </header>
    </div>
    <div class="drawer-side">
      <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
      <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
        <h1 class="text-3xl font-bold mb-6 font-allura">Beautiworks by Fifi</h1>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('about-us') }}">Tentang Kami</a></li>
        <li>
          <details>
            <summary>Portfolio</summary>
            <ul>
              <li><a href="{{ route('portofolio.team') }}">Make up Team</a></li>
              <li><a href="{{ route('portofolio.wedding') }}">Make Up Wedding</a></li>
              <li><a href="{{ route('portofolio.event') }}">Make Up Events</a></li>
              <li><a href="{{ route('portofolio.class') }}">Make Up Class</a></li>
            </ul>
          </details>
        </li>
        <li><a href="{{ route('syarat') }}">Syarat & Ketentuan</a></li>
        <li><a href="{{ route('layanan') }}">Layanan Kami</a></li>
        <li><a href="{{ route('testimoni') }}">Testimoni</a></li>
        <li><a href="{{ route("hubungi-kami") }}">Hubungi Kami</a></li>
        @guest
        <li><a href="{{ route("login") }}">Login</a></li>
        @else
        @if(Auth::user()->role === 'admin')
        <li><a href="{{ route('dashboard') }}">Dashboard Admin</a></li>
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary w-[100%] mt-5">Logout</button>
        </form>
        @elseif(Auth::user()->role === 'user')
        <li>
          

          <details>
            <summary>Reservasi</summary>
            <ul>
              <li><a href="{{ route('appointment') }}">Buat Appointment</a></li>
              <li><a href="{{ route('reservation') }}">Reservasi (Khusus make-up class)</a></li>
            </ul>
          </details>
        </li>
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary w-[100%] mt-5">Logout</button>
        </form>
        @endif
        @endguest
      </ul>
    </div>
  </div>

  <main class="p-6">
    {{ $slot }}
  </main>
</body>

</html>
