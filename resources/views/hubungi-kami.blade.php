<x-layout>
  <div class="container mx-auto px-4 py-10 items-center">
    <h1 class="text-center text-pink-600 text-3xl font-semibold mb-2">Beautyworks by Fifi</h1>
    <h2 class="text-center text-pink-600 text-2xl font-medium mb-10">Contact Us</h2>

    <div class="grid md:grid-cols-2 gap-8 items-start">
      <!-- Map -->
      <div class="w-full">
        <iframe class="rounded-xl w-full h-80"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2983282269775!2d106.8291389!3d-6.223876199999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec1f499ea449%3A0x53ff4e511e33d2b5!2sBeautyworks%20by%20Fifi%20Wedding%20Gallery!5e0!3m2!1sen!2sid!4v1718600000000"
          allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

      <!-- Contact Info -->
      <div class="space-y-6">
        <div class="flex items-start space-x-4">
          <!-- <img src="{{ asset('icons/location.png') }}" class="w-6 h-6 mt-1" alt="Location Icon"> -->
          <p class="text-pink-600 font-medium">
            Jl. Margonda No.459, Pondok Cina, Kecamatan Beji,<br>
            Kota Depok, Jawa Barat 16424
          </p>
        </div>
        <div class="flex items-center space-x-4">
          <!-- <img src="{{ asset('icons/phone.png') }}" class="w-6 h-6" alt="Phone Icon"> -->
          <p class="text-pink-600 font-semibold">081917031992</p>
        </div>
        <div class="flex items-center space-x-4">
          <!-- <img src="{{ asset('icons/email.png') }}" class="w-6 h-6" alt="Email Icon"> -->
          <p class="text-pink-600">Beautyworksbyfifi@gmail.com</p>
        </div>
        <div class="flex items-center space-x-4">
          <!-- <img src="{{ asset('icons/instagram.png') }}" class="w-6 h-6" alt="Instagram Icon"> -->
          <p class="text-pink-600">@beautyworksbyfifi</p>
        </div>
      </div>
    </div>
  </div>
</x-layout>