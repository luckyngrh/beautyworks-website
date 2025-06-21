<x-layout>
  <h1 class="text-4xl text-center mb-2">Buat Appointment di <span class="font-allura text-5xl">Beautyworks by Fifi</span></h1>
  <form action="{{ route('appointment.store') }}" method="post">
    @csrf
    <div class="bg-base-300 p-4 rounded-lg w-xl mx-auto">
      <div class="flex flex-row gap-4 mb-4">
        <div class="flex-[50%]">
          <legend for="" class="text-xl mb-1">Tanggal :</legend>
          <input type="date" class="input w-full mb-2" name="tanggal_appointment" />
      </div>
      
      <div class="flex-[50%]">
        <legend for="" class="text-xl mb-1">Jam :</legend>
        <input type="time" class="input w-full" name="waktu_appointment"/>
        <span class="text-sm">(tersedia dari 09.00 - 17.00 WIB)</span>
      </div>
    </div>
    
    <legend for="" class="text-lg mb-1">Jenis Layanan :</legend>
    <select name="jenis_layanan" class="w-full select select-bordered mb-3">
      <option disabled selected>Pilih jenis layanan</option>
      <option value="Make-up Wedding">Make-up Wedding</option>
      <option value="Make-up Reguler">Make-up Reguler/Event</option>
    </select>
    
    <button type="submit" class="btn btn-primary w-full"><i class="bi bi-send-fill"></i>Kirim</button>
  </div>
</form>
</x-layout>