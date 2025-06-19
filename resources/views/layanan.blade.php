<x-layout>
  <h1 class="text-center text-3xl">Our Services</h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center w-full">
    <div>
      <div class="flex items-center justify-center min-h-14 mb-5">
        <h3 class="text-pink-600 text-xl font-semibold">Make-Up Wedding</h3>
      </div>
      <img src="{{ asset('images/fifi.jpg') }}" alt="Makeup Wedding"
        class="mx-auto object-cover rounded-lg shadow-md mb-2">
      <p class="text-gray-700 min-h-20 mb-2">Untuk Akad & Resepsi, bisa Retouch</p>
      <a href="{{ route('reservasi') }}"
        class="inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded hover:bg-pink-50 transition">
        Reservation Now
      </a>
    </div>

    <!-- Reguler Make-up -->
    <div>
      <div class="flex items-center justify-center min-h-14 mb-5">
        <h3 class="text-pink-600 text-xl font-semibold">Reguler Make-up</h3>
      </div>
      <img src="{{ asset('images/fifi.jpg') }}" alt="Makeup Wedding"
        class="mx-auto object-cover rounded-lg shadow-md mb-2">
      <p class="text-gray-700 min-h-20 mb-2">Make-Up Photoshoot, Make-Up Wisuda, Make-Up Party</p>
      <a href="{{ route('reservasi') }}"
        class="inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded hover:bg-pink-50 transition">
        Reservation Now
      </a>
    </div>

    <!-- Make-Up Class -->
    <div>
      <div class="flex items-center justify-center min-h-14 mb-5">
        <h3 class="text-pink-600 text-xl font-semibold">Make-Up Class</h3>
      </div>
      <img src="{{ asset('images/fifi.jpg') }}" alt="Makeup Wedding"
        class="mx-auto object-cover rounded-lg shadow-md mb-2">
      <p class="text-gray-700 min-h-20 mb-2">Basic Makeup Class, Professional Class, Private Class</p>
      <a href="{{ route('reservasi') }}"
        class="inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded hover:bg-pink-50 transition">
        Reservation Now
      </a>
    </div>

    <!-- Make-up Consultation -->
    <div>
      <div class="flex items-center justify-center min-h-14 mb-5">
        <h3 class="text-pink-600 text-xl font-semibold">Make-up Consultation</h3>
      </div>
      <img src="{{ asset('images/fifi.jpg') }}" alt="Makeup Wedding"
        class="mx-auto object-cover rounded-lg shadow-md mb-2">
      <p class="text-gray-700 min-h-20 mb-2">Consultations are available via WhatsApp, Instagram, or live chat.</p>
      <a href="{{ route('reservasi') }}"
        class="inline-block px-4 py-2 border border-pink-500 text-pink-500 rounded hover:bg-pink-50 transition">
        Reservation Now
      </a>
    </div>
  </div>
  <!-- <div class="flex flex-col items-center gap-4 mt-6">
    <h2 class="font-bold text-2xl text-center">Wedding Make-Up</h2>
    <img class="w-[10px]" src="{{ asset('images/fifi.jpg') }}" alt="Makeup Wedding">
    <p class="">Untuk Akad & Resepsi, bisa Retouch</p>
    <a class="btn btn-primary btn-outline" href="">Reservasi Sekarang</a>
  </div> -->

</x-layout>