<x-layout>
  <h1 class="text-4xl text-center mb-2">Buat Reservasi di <span class="font-allura text-5xl">Beautyworks by
      Fifi</span></h1>
  <form action="{{ route('reservation.store') }}" method="post">
    @csrf
    <div class="bg-base-300 p-4 rounded-lg w-xl mx-auto">
      {{-- Display Validation Errors --}}
      @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      {{-- Display Success Message --}}
      @if (session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
      </div>
      @endif

      <div class="flex flex-row gap-4 mb-4">
        <div class="flex-[50%]">
          <legend for="" class="text-xl mb-1">Tanggal :</legend>
          <input type="date" class="input w-full mb-2" name="tanggal_appointment"
            value="{{ old('tanggal_appointment') }}" />
        </div>

        <div class="flex-[50%]">
          <legend for="" class="text-xl mb-1">Jam :</legend>
          <input type="time" class="input w-full" name="waktu_appointment" value="{{ old('waktu_appointment') }}" />
          <span class="text-sm">(tersedia dari 07.00 - 17.00 WIB)</span>
        </div>
      </div>

      <legend for="" class="text-lg mb-1">Jenis Layanan :</legend>
      <select name="jenis_layanan" class="w-full select select-bordered mb-3">
        <option disabled selected>Pilih jenis layanan</option>
        <option value="Make-up Class" selected>Make-up Class</option>
      </select>

      <button type="submit" class="btn btn-primary w-full"><i class="bi bi-send-fill"></i>Kirim</button>
    </div>
  </form>
</x-layout>