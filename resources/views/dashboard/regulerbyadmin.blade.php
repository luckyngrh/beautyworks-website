<x-dashboard-layout>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Buat Pesanan Make-up Reguler dari Admin</h1>

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

    <form action=" " method="post" class="bg-white p-6 rounded-lg shadow-md">
      @csrf

      <div class="mb-4">
        <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Pelanggan :</label>
        <input type="text" id="nama" name="nama"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="kontak" class="block text-gray-700 text-sm font-bold mb-2">Kontak :</label>
        <input type="text" id="kontak" name="kontak"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
        @error('kontak')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="nama_mua" class="block text-gray-700 text-sm font-bold mb-2">Nama MUA :</label>
        <input type="text" id="nama_mua" name="nama_mua"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="jenis_layanan" class="block text-gray-700 text-sm font-bold mb-2">Jenis Layanan</label>
        <input type="text" id="jenis_layanan"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required disabled value="Make-up Reguler">
        <input type="text" id="jenis_layanan" name="jenis_layanan" value="Make-up Reguler" hidden>
      </div>

      <div class="mb-4">
        <label for="tanggal_appointment" class="block text-gray-700 text-sm font-bold mb-2">Tanggal :</label>
        <input type="date" id="tanggal_appointment" name="tanggal_appointment"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
        @error('tanggal_appointment')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="waktu_appointment" class="block text-gray-700 text-sm font-bold mb-2">Jam :</label>
        <input type="time" id="waktu_appointment" name="waktu_appointment"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
        @error('waktu_appointment')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>


      <div class="flex items-center">
        <button type="submit" class="btn btn-secondary">
          Buat Appointment
        </button>
        <a href="{{ route('dashboard') }}" class="btn btn-neutral ml-2">
          Kembali
        </a>
      </div>
    </form>
  </div>
</x-dashboard-layout>