<x-layout>
  <div class="flex justify-center items-center gap-7 p-4 px-7">
    <div>
      <h1 class="text-4xl leading-14">Radiate Beauty on Your Special Day with <span
          class="font-bold font-allura text-7xl">Beautyworks by Fifi</span></h1>
      <p class="text-2xl">Crafting Confidence, One Bride at a Time</p>
      <a class="btn btn-primary mt-4" href="{{ route('appointment') }}">Reservation Now</a>
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