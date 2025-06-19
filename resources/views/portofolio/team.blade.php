<x-layout>
  <div class="container mx-auto max-w-4xl px-4 py-8">
    <h1 class="text-3xl text-center font-semibold text-pink-600 mb-8">Make up Team</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-items-center">
      @php
      $team = [
      ['name' => 'Fifi', 'image' => 'fifi.jpg'],
      ['name' => 'Salma', 'image' => 'salma.jpg'],
      ['name' => 'Zahra', 'image' => 'zahra.jpg'],
      ];
      @endphp

      @foreach ($team as $member)
      <div
        class="bg-[#7A6753] rounded-lg p-3 shadow-md text-white flex flex-col items-center w-[200px] hover:scale-105 transition duration-300">
        <p class="text-sm text-center mb-2 leading-tight">Beautyworks by Fifi<br>MUA Team</p>

        <!-- Gambar -->
        <div class="w-[150px] h-[200px] bg-white rounded shadow overflow-hidden">
          <img src="{{ asset('images/' . $member['image']) }}" alt="{{ $member['name'] }}"
            class="w-full h-full object-cover">
        </div>

        <!-- Nama -->
        <div class="mt-2 font-cursive text-lg">{{ $member['name'] }}</div>
        <div class="w-8 h-px bg-yellow-400 mt-2"></div>
      </div>
      @endforeach
    </div>
  </div>
</x-layout>