<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Dashboard</H1>
  <div class="flex flex-col md:flex-row gap-4 mb-4">
    <div class="flex items-center justify-center border-2 border-primary rounded-lg max-w-fit p-3">
      <div class="flex flex-row items-center gap-6">
        <i class="bi bi-calendar-event text-7xl"></i>
        <div class="flex flex-col space-x-4 mb-2">
          <h2 class="text-2xl font-semibold pt-2">Total Pesanan</h2>
          {{-- You can dynamically calculate this total --}}

        </div>
      </div>
    </div>
    <div class="flex items-center justify-center border-2 border-primary rounded-lg max-w-fit p-3">
      <div class="flex flex-row items-center gap-6">
        <i class="bi bi-calendar-heart text-7xl"></i>
        <div class="flex flex-col space-x-4 mb-2">
          <h2 class="text-2xl font-semibold pt-2">Acara Mendatang</h2>
          {{-- You can dynamically calculate this total for upcoming events --}}
          <p class="text-4xl mt-2 text-left">

          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline justify-between">
    {{-- Form Pencarian --}}
    <form action="" method="GET" class="join">
      <div>
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama MUA" name="search" value="{{ request('search') }}" />
        </label>
      </div>
      <button type="submit" class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
    </form>

    <a href="" class="btn btn-primary"><i class="bi bi-patch-plus-fill"></i>Tambah Pesanan</a>
  </div>

  <div
    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4 overflow-y-auto rounded-box border border-base-content bg-base-200 p-3">
    <div class="flex flex-col border-2 text-center overflow-auto rounded-box bg-primary text-primary-content pb-2">
      <div>
        <H3 class="text-2xl font-semibold">
          10
        </H3>
      </div>
      <p>Fifi</p>
      <p>Make-up Wedding</p>
      <p>
        10.00
      </p>
    </div>
  </div>

</x-dashboard-layout>