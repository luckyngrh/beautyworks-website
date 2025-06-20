<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautyworks</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="drawer">
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <header class="flex items-center justify-between p4 px-7 pt-4">
                <label for="my-drawer" class="btn btn-circle swap swap-rotate">
                    <input type="checkbox" />

                    <svg
                        class="swap-off fill-current"
                        xmlns="http://www.w3.org/2000/svg"
                        width="32"
                        height="32"
                        viewBox="0 0 512 512">
                        <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
                    </svg>

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
                <h1 class="text-3xl">Halo, {{ auth()->user()->name }}</h1>
                <!-- <img class="w-[10%]" src="{{ asset('images/logo.png') }}" alt="Logo"> -->
            </header>
        </div>
        <div class="drawer-side">
            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
              <div class="flex items-center justify-center mb-6 pt-6">
                <img class="w-[50%]" src="{{ asset('images/logo.png') }}" alt="Logo">
              </div>
              <div class="flex flex-col items-center gap-4 justify-between h-96">
                <div>
                  <h1 class="text-3xl font-bold mb-6">Beautiworks by Fifi</h1>
                  <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  <li><a href="{{ route('dashboard.reservasi') }}">Reservasi</a></li>
                  <li><a href="{{ route('dashboard.kelas-makeup') }}">Kelas Make up</a></li>
                </div>
                <div class="">
                  <!-- <li> -->
                    <form action="{{ route('logout') }}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-error w-60">Logout</button>
                    </form>
                  <!-- </li> -->
                </div>    
              </div>
            </ul>
        </div>
    </div>

    <main class="p-6">
        {{ $slot }}
    </main>
</body>
</html>