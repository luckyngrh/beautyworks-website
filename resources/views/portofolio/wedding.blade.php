<x-layout>
  <div class="container mx-auto px-4 py-10">
    <h2 class="text-center text-3xl font-semibold mb-10">Wedding Make Up</h2>

    <div class="grid grid-cols-3 bg-base-300 rounded-box items-center justify-items-center gap-8 p-4">
      @for($i = 1; $i <= 6; $i++)
        <div class="w-64">
          <img src="{{ asset('images/wedding'.$i.'.jpg') }}" class="rounded-box" />
        </div>
      @endfor
    </div>
  </div>

</x-layout>