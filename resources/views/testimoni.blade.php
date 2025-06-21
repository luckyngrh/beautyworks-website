<x-layout>
  <h2 class="text-center text-3xl font-semibold mb-10 mx-auto">Testimoni Pelanggan Kami</h2>
  <div class="grid grid-cols-3 gap-8 justify-items-center">
  <!-- <div class="flex flex-row gap-8 justify-items-center"> -->
    @php
    $photos = [
    'Gambar2.jpg',
    'Gambar4.jpg',
    'Gambar3.jpg',
    ];
    @endphp
    @for ($i = 1; $i <= 6; $i++) <div class="w-3/4 rounded-xl shadow-lg">
      <img src="{{ asset('images/testimoni'.$i.'.jpg') }}" alt="Wedding Make Up"
        class="w-full h-full object-cover rounded-xl">
  </div>
  @endfor
  </div>
</x-layout>