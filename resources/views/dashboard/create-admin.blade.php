<x-dashboard-layout>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Data Admin Baru</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
      <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('dashboard.store-admin') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
      @csrf

      <div class="mb-4">
        <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Admin:</label>
        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="no_telp" class="block text-gray-700 text-sm font-bold mb-2">No. Telepon:</label>
        <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <!-- <div class="flex items-center justify-between"> -->
      <button type="submit" class="btn btn-secondary">
        Simpan Data
      </button>
      <a href="{{ route('dashboard.akun-admin') }}" class="btn btn-neutral ml-2">
        Kembali
      </a>
  </div>
  </form>
  </div>
</x-dashboard-layout>