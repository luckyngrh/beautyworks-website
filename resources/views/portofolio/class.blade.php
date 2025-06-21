<x-layout>
  <div class="container mx-auto">
    <h1 class="text-3xl text-center font-semibold mb-8">Make up Class</h1>
    <div class="mb-2">
      <img src="{{ asset('images/class-landscape.jpg') }}" class="rounded-box w-1/2 block mx-auto" />
    </div>
    <div class="grid grid-cols-3 bg-base-300 rounded-box items-center justify-items-center gap-8 p-4">
      @for($i = 1; $i <= 6; $i++) <div class="w-64">
        <img src="{{ asset('images/class'.$i.'.jpg') }}" class="rounded-box" />
    </div>
    @endfor
  </div>
  </div>
</x-layout>