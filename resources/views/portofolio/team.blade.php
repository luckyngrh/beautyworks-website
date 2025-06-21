<x-layout>
  <div class="container mx-auto">
    <h1 class="text-3xl text-center font-semibold mb-8">Make up Team</h1>

    <style>
    /* Define the animation for the continuous scroll */
    @keyframes scroll-left {
      0% {
        transform: translateX(0%);
      }

      100% {
        transform: translateX(-100%);
      }
    }

    /* Apply the animation to the scrolling container */
    .animate-scroll {
      animation: scroll-left 70s linear infinite;
      /* Adjust duration as needed */
    }

    /* To create the infinite loop, we'll duplicate the content */
    .scroll-container:hover .animate-scroll {
      animation-play-state: paused;
      /* Pause on hover */
    }
    </style>

    <div class="relative overflow-hidden">
      <div class="flex scroll-container whitespace-nowrap">
        @php
        $team = [
        ['name' => 'Ari', 'image' => 'ari.jpg'],
        ['name' => 'Fifi', 'image' => 'fifi.jpg'],
        ['name' => 'Nisa', 'image' => 'nisa.jpg'],
        ['name' => 'Salma', 'image' => 'salma.jpg'],
        ['name' => 'Shafa', 'image' => 'shafa.jpg'],
        ['name' => 'Tari', 'image' => 'tari.jpg'],
        ['name' => 'Zahra', 'image' => 'zahra.jpg'],
        ];
        // Duplicate the team array to create a seamless loop
        $team_duplicated = array_merge($team, $team);
        @endphp

        <div class="flex animate-scroll">
          @foreach ($team_duplicated as $member)
          <div
            class="flex-none bg-[#7A6753] rounded-lg p-3 shadow-md text-white flex flex-col items-center w-[200px] hover:scale-105 transition duration-300 mx-2">
            <div class="bg-white rounded shadow overflow-hidden">
              <img src="{{ asset('images/' . $member['image']) }}" alt="{{ $member['name'] }}"
                class="w-full h-full object-cover">
            </div>

            <div class="mt-2 font-cursive text-lg mx-auto">{{ $member['name'] }}</div>
            <div class="w-16 h-px bg-yellow-400 mx-auto"></div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</x-layout>