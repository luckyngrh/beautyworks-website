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
        <input type="text" id="nama_pelanggan"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          value="{{ $reservation->user->nama }}" required disabled>
      </div>

      <div class="mb-4">
        <label for="id_mua" class="block text-gray-700 text-sm font-bold mb-2">Nama MUA :</label>
        <select class="w-full select select-bordered mb-3" name="id_mua" id="id_mua">
          <option value="">Pilih MUA</option>
          @foreach ($availableMuas as $mua)
          <option value="{{ $mua->id_mua }}" {{ $reservation->id_mua == $mua->id_mua ? 'selected' : '' }}>
            {{ $mua->nama_mua }}
          </option>
          @endforeach
        </select>
        @error('id_mua')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="jenis_layanan" class="block text-gray-700 text-sm font-bold mb-2">Jenis Layanan :</label>
        <select class="w-full select select-bordered mb-3" name="jenis_layanan" id="jenis_layanan">
          <option value="Make-up Reguler" {{ $reservation->jenis_layanan == 'Make-up Reguler' ? 'selected' : '' }}>
            Make-up Reguler</option>
          <option value="Make-up Wedding" {{ $reservation->jenis_layanan == 'Make-up Wedding' ? 'selected' : '' }}>
            Make-up Wedding</option>
        </select>
        @error('status')
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
        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status :</label>
        <select class="w-full select select-bordered mb-3" name="status" id="status">
          <option value="Menunggu Konfirmasi" {{ $reservation->status == 'Menunggu Konfirmasi' ? 'selected' : '' }}>
            Menunggu Konfirmasi</option>
          <option value="Diproses" {{ $reservation->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
          <option value="Selesai" {{ $reservation->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
          <option value="Dibatalkan" {{ $reservation->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
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