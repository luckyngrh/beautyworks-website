<x-dashboard-layout>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Data Appointment</h1>

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

    <form action="" method="POST" class="bg-white p-6 rounded-lg shadow-md">
      @csrf
      @method('PUT') {{-- Use PUT method for update --}}

      <div class="mb-4">
        <label for="" class="block text-gray-700 text-sm font-bold mb-2">Nama Pelanggan :</label>
        <input type="text"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required disabled>
      </div>

      <div class="mb-4">
        <label for="no_telp" class="block text-gray-700 text-sm font-bold mb-2">Nama MUA :</label>
        <select class="w-full select select-bordered mb-3">
          <option disabled selected>Pilih MUA</option>
          <option value="">Fifi</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="no_telp" class="block text-gray-700 text-sm font-bold mb-2">Jenis Layanan :</label>
        <input type="text"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="" class="block text-gray-700 text-sm font-bold mb-2">Tanggal :</label>
        <input type="date"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="" class="block text-gray-700 text-sm font-bold mb-2">Jam :</label>
        <input type="text"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="" class="block text-gray-700 text-sm font-bold mb-2">Kontak :</label>
        <input type="text"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="" class="block text-gray-700 text-sm font-bold mb-2">Status :</label>
        <select class="w-full select select-bordered mb-3">
          <option disabled selected>Konfirmasi</option>
          <option value="">Menunggu Konfirmasi</option>
          <option value="">Diproses</option>
          <option value="">Selesai</option>
          <option value="">Dibatalkan</option>
        </select>
      </div>

      <div class="flex items-center">
        <button type="submit" class="btn btn-secondary">
          Update MUA
        </button>
        <a href="" class="btn btn-neutral ml-2">
          Kembali
        </a>
      </div>
    </form>
  </div>
</x-dashboard-layout>