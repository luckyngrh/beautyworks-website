<x-dashboard-layout>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Data Reservasi</h1>

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

    <form action="{{ route('dashboard.update-reservation', $reservation->id_reservation) }}" method="POST"
      class="bg-white p-6 rounded-lg shadow-md">
      @csrf
      @method('PUT') {{-- Use PUT method for update --}}

      <div class="mb-4">
        <label for="nama_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">Nama Pelanggan :</label>
        <input type="text" id="nama_pelanggan" name="nama"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{ $reservation->nama }}" required>
      </div>

      <div class="mb-4">
        <label for="nama_mua" class="block text-gray-700 text-sm font-bold mb-2">Nama MUA :</label>
        <input type="text" id="nama_mua" name="nama_mua"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{ $reservation->nama_mua }}">
      </div>

      <div class="mb-4">
        <label for="jenis_layanan" class="block text-gray-700 text-sm font-bold mb-2">Jenis Layanan :</label>
        <input type="text" id="jenis_layanan" name="jenis_layanan"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{ $reservation->jenis_layanan }}" disabled>
        {{-- Add a hidden input to ensure jenis_layanan is sent with the form --}}
        <input type="hidden" name="jenis_layanan" value="{{ $reservation->jenis_layanan }}">
        @error('jenis_layanan')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="tanggal_reservation" class="block text-gray-700 text-sm font-bold mb-2">Tanggal :</label>
        <input type="date" id="tanggal_reservation" name="tanggal_reservation"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{ $reservation->tanggal_reservation }}" required>
        @error('tanggal_reservation')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="waktu_reservation" class="block text-gray-700 text-sm font-bold mb-2">Jam :</label>
        <input type="time" id="waktu_reservation" name="waktu_reservation"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{\Carbon\Carbon::parse($reservation->waktu_reservation)->format('H:i') }}" required>
        @error('waktu_reservation')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="kontak" class="block text-gray-700 text-sm font-bold mb-2">Kontak :</label>
        <input type="text" id="kontak" name="kontak"
          class="input shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{ $reservation->kontak }}" required>
        @error('kontak')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">status :</label>
        <input type="text" id="status" name="status"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{ $reservation->status }}" disabled>
        {{-- Add a hidden input to ensure status is sent with the form --}}
        <input type="hidden" name="status" value="{{ $reservation->status }}">
        @error('status')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between">
        <button type="submit" class="btn btn-secondary">
          Update Reservation
        </button>
        <a href="{{ route('dashboard.reservasi-reguler') }}" class="btn btn-neutral ml-2">
          Kembali
        </a>
      </div>
  </div>
</x-dashboard-layout>