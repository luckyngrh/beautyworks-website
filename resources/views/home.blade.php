<x-layout>
    <div class="flex justify-center items-center gap-7 p-4 px-7">
        <div>
            <h1 class="text-4xl leading-14">Radiate Beauty on Your Special Day with <span class="font-bold font-allura text-7xl">Beautyworks by Fifi</span></h1>
            <p class="text-2xl">Crafting Confidence, One Bride at a Time</p>
            <a class="btn btn-primary mt-4" href="{{ route('appointment') }}">Reservation Now</a>
        </div>
        <div class="w-2/3">
            <img class="rounded-tl-full rounded-tr-full" src="{{ asset('images/wedding1.jpg') }}" alt="Bride Image">
        </div>
    </div>
</x-layout>