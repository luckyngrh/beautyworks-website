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
</x-dashboard-layout>