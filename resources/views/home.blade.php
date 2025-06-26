<x-layout>
  <div class="flex justify-center items-center gap-7 p-4 px-7">
    <div>
      <h1 class="text-4xl leading-14">Radiate Beauty on Your Special Day with <span
          class="font-bold font-allura text-7xl">Beautyworks by Fifi</span></h1>
      <p class="text-2xl">Crafting Confidence, One Bride at a Time</p>
      @guest
        <a class="btn btn-primary mt-4" href="{{ route('login') }}">Reservation Now</a>
      @else
        <div class="dropdown dropdown-start mt-2">
          <div tabindex="0" role="button" class="btn btn-primary m-1">Reservation Now</div>
          <ul tabindex="0" class="dropdown-content menu bg-base-200 rounded-box z-1 w-52 p-2 shadow-sm">
            <li><a href="{{ route('appointment') }}">Buat Appointment</a></li>
            <li><a href="{{ route('reservation') }}">Reservasi (Khusus kelas make-up)</a></li>
          </ul>
        </div>
      @endif

    </div>
    <div class="w-2/3">
      <img class="rounded-tl-full rounded-tr-full" src="{{ asset('images/wedding1.jpg') }}" alt="Bride Image">
    </div>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
      Tawk_LoadStart = new Date();
    (function() {
      var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/685802e5f4cfc5190e97f49c/1iubsmk9l';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
  </div>
</x-layout>