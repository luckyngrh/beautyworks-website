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
    <form action="{{ route('dashboard') }}" method="GET" class="join">
      <div>
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama MUA" name="search" value="{{ request('search') }}" />
        </label>
      </div>
      <button type="submit" class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
    </form>

    <div>
      <a href="{{ route('appointment') }}" class="btn btn-primary bi bi-patch-plus-fill">Tambah Pesanan</a>
    </div>
  </div>

  <div
    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4 overflow-y-auto rounded-box border border-base-content bg-base-200 p-3">
    @forelse ($sortedBookings as $booking)
    <div class="flex flex-col border-2 text-center overflow-auto rounded-box bg-primary text-primary-content pb-2">
      <div>
        <H3 class="text-2xl font-semibold">
          {{ \Carbon\Carbon::parse($booking->tanggal_appointment ?? $booking->tanggal_reservation)->format('d') }}
        </H3>
        <p>
          {{ \Carbon\Carbon::parse($booking->tanggal_appointment ?? $booking->tanggal_reservation)->format('l') }}
        </p>
      </div>
      <p>{{ $booking->mua->nama_mua ?? 'Belum Ditentukan' }}</p>
      <p>{{ $booking->jenis_layanan }}</p>
      <p>{{ \Carbon\Carbon::parse($booking->waktu_appointment ?? $booking->waktu_reservation)->format('H:i') }}</p>
    </div>
    @empty
    <p class="col-span-full text-center text-gray-500">Tidak ada booking yang tersedia.</p>
    @endforelse
  </div>

</x-dashboard-layout>