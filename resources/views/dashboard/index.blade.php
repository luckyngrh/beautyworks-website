<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Dashboard</H1>
  <div class="flex flex-col md:flex-row gap-4 mb-4">
    <div class="flex items-center justify-center border-2 border-primary rounded-lg max-w-fit p-3">
      <div class="flex flex-row items-center gap-6">
        <i class="bi bi-calendar-event text-7xl"></i>
        <div class="flex flex-col space-x-4 mb-2">
          <h2 class="text-2xl font-semibold pt-2">Total Pesanan</h2>
          <p class="text-4xl mt-2 text-left">5</p>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center border-2 border-primary rounded-lg max-w-fit p-3">
      <div class="flex flex-row items-center gap-6">
        <i class="bi bi-calendar-heart text-7xl"></i>
        <div class="flex flex-col space-x-4 mb-2">
          <h2 class="text-2xl font-semibold pt-2">Acara Mendatang</h2>
          <p class="text-4xl mt-2 text-left">5</p>
        </div>
      </div>
    </div>
  </div>

  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline justify-between">
    <div class="join">
      <div>
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama" required />
        </label>
      </div>
      <button class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
    </div>

    <div>
      <button class="btn btn-primary bi bi-patch-plus-fill">Tambah Pesanan</button>
    </div>
  </div>

  <div class="grid grid-cols-7 grid-rows-5 gap-4 overflow-y-auto rounded-box border border-base-content bg-base-200 p-3">
    <div class="flex flex-col border-2 text-center overflow-auto rounded-box bg-primary text-primary-content pb-2">
      <div>
        <H3 class="text-2xl font-semibold">23</H3>
        <p>Senin</p>
      </div>
      <p>Fifi</p>
      <p>Make-up Wedding</p>
      <p>10.00</p>
    </div>

    <div class="flex flex-col border-2 text-center overflow-auto rounded-box bg-primary text-primary-content pb-2">
      <div>
        <H3 class="text-2xl font-semibold">23</H3>
        <p>Senin</p>
      </div>
      <p>Tari</p>
      <p>Make-up Wedding</p>
      <p>11.00</p>
    </div>

    <div class="flex flex-col border-2 text-center overflow-auto rounded-box bg-primary text-primary-content pb-2">
      <div>
        <H3 class="text-2xl font-semibold">25</H3>
        <p>Rabu</p>
      </div>
      <p>Salma</p>
      <p>Make-up Class</p>
      <p>13.00</p>
    </div>

  </div>

</x-dashboard-layout>