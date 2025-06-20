<x-layout>
    <div class="flex flex-col items-center h-screen gap-4 pt-6">
        <h1 class="text-3xl">Selamat Datang Admin!</h1>
        <p>Ini adalah halaman dashboard admin.</p>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-error">Logout</button>
        </form>
    </div>
</x-layout>