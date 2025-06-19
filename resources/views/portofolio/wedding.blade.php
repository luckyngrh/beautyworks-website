<x-layout>
  <div class="container mx-auto px-4 py-10">
    <!-- Judul -->
    <h1 class="text-center text-pink-600 text-3xl font-semibold mb-4">Beautyworks by Fifi</h1>
    <h2 class="text-center text-pink-600 text-2xl font-medium mb-10">Wedding Make Up</h2>

    <!-- Grid Foto -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 justify-items-center">
      @php
      $photos = [
      'Gambar2.jpg',
      'Gambar4.jpg',
      'Gambar3.jpg',
      ];
      @endphp

      @foreach ($photos as $photo)
      <div class="w-[250px] h-[320px] overflow-hidden rounded-xl shadow-lg">
        <img src="{{ asset('images/' . $photo) }}" alt="Wedding Make Up" class="w-full h-full object-cover rounded-xl">
      </div>
      @endforeach
    </div>
  </div>
</x-layout>