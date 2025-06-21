<x-layout>
  <div class="container mx-auto">
    <h1 class="text-3xl text-center font-semibold mb-8">Make up Events</h1>
    <div class="grid grid-cols-4 bg-base-300 rounded-box items-center justify-items-center gap-8 p-4">
      @for($i = 1; $i <= 4; $i++) <div class="w-64">
        <img src="{{ asset('images/events'.$i.'.jpg') }}" class="rounded-box" />
    </div>
    @endfor
  </div>
  </div>
</x-layout>