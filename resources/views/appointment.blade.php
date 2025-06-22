<x-layout>
  <h1 class="text-4xl text-center mb-2">Buat Appointment di <span class="font-allura text-5xl">Beautyworks by
      Fifi</span></h1>

  <div class="grid grid-cols-2 grid-rows-2 gap-4">
    <div class="flex place-items-end justify-end flex-col gap-2">
      <calendar-date class="cally bg-base-100 border border-base-300 shadow-lg rounded-box" id="reservationCalendar">
        <svg aria-label="Previous" class="fill-current size-4" slot="previous" xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24">
          <path fill="currentColor" d="M15.75 19.5 8.25 12l7.5-7.5"></path>
        </svg>
        <svg aria-label="Next" class="fill-current size-4" slot="next" xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24">
          <path fill="currentColor" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
        </svg>
        <calendar-month></calendar-month>
      </calendar-date>
      {{-- Removed type="submit" from this button as we'll handle with JS --}}
      <button type="button" class="btn btn-primary w-[18rem]" id="checkAvailabilityBtn">Cek Ketersediaan</button>
    </div>

    <form action="{{ route('appointment.store') }}" method="post" class="flex items-center justify-center w-72">
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

        <div class="flex flex-col gap-4 mb-4">
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
          <option value="Make-up Wedding" {{ old('jenis_layanan') == 'Make-up Wedding' ? 'selected' : '' }}>Make-up
            Wedding</option>
          <option value="Make-up Reguler" {{ old('jenis_layanan') == 'Make-up Reguler' ? 'selected' : '' }}>Make-up
            Reguler/Event</option>
        </select>

        <button type="submit" class="btn btn-primary w-full"><i class="bi bi-send-fill"></i>Kirim</button>
      </div>
    </form>

    <div class="col-span-2">
      <h2 class="text-2xl text-center">List Booking</h2>
      <div class="border-2 rounded-box p-4" id="bookingList">
        {{-- Booking list will be loaded here via AJAX --}}
        <p class="text-center text-gray-500">Pilih tanggal untuk melihat daftar booking.</p>
      </div>
    </div>
  </div>


  <script type="module" src="https://unpkg.com/cally"></script>
</x-layout>