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
        transform: translateX(-50%);
        /* Scroll 50% to show the duplicate set */
      }
    }

    /* Apply the animation to the scrolling container */
    .animate-scroll-infinite {
      animation: scroll-left 30s linear infinite;
      /* Adjust duration as needed */
      /* Kita akan menggunakan JavaScript untuk memastikan lebar konten */
    }

    /* Pause on hover */
    .scroll-wrapper:hover .animate-scroll-infinite {
      animation-play-state: paused;
    }
    </style>

    <div class="relative overflow-hidden">
      <div class="flex scroll-wrapper">
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
        // Duplikasikan array tim dua kali untuk memastikan kelancaran
        // (misal: A,B,C,D,E,F,G,A,B,C,D,E,F,G)
        $team_duplicated_for_infinite = array_merge($team, $team);
        @endphp

        <div class="flex flex-nowrap animate-scroll-infinite" id="scrolling-content">
          @foreach ($team_duplicated_for_infinite as $member)
          <div
            class="flex-none bg-[#7A6753] rounded-lg p-3 shadow-md text-white flex flex-col items-center w-[200px] hover:scale-105 transition duration-300 mx-2 my-4">
            <div class="bg-white rounded shadow overflow-hidden">
              <img src="{{ asset('images/' . $member['image']) }}" alt="{{ $member['name'] }}"
                class="w-full h-[200px] object-cover">
            </div>

            <div class="mt-2 font-cursive text-lg mx-auto">{{ $member['name'] }}</div>
            <div class="w-16 h-px bg-yellow-400 mx-auto"></div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  {{-- Script untuk mengatur lebar total konten yang digulirkan --}}
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const scrollingContent = document.getElementById('scrolling-content');
    const items = scrollingContent.children;
    let totalWidth = 0;

    // Hitung total lebar semua item, termasuk margin
    for (let i = 0; i < items.length; i++) {
      totalWidth += items[i].offsetWidth + (parseFloat(getComputedStyle(items[i]).marginLeft) || 0) + (parseFloat(
        getComputedStyle(items[i]).marginRight) || 0);
    }

    // Set lebar elemen container agar mencukupi untuk dua set item
    // Ini penting agar animasi translateX(-50%) bisa bekerja dengan benar
    // Lebar ini harus cukup untuk menampung set asli dan duplikatnya secara berdampingan.
    scrollingContent.style.width = `${totalWidth}px`;
  });
  </script>
</x-layout>