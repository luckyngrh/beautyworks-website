<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Dashboard</H1>
  <div class="flex flex-col md:flex-row gap-4 mb-4">
    <div class="flex items-center justify-center border-2 border-primary rounded-lg max-w-fit p-3">
      <div class="flex flex-row items-center gap-6">
        <i class="bi bi-calendar-event text-7xl"></i>
        <div class="flex flex-col space-x-4 mb-2">
          <h2 class="text-2xl font-semibold pt-2">Total Pesanan</h2>
          {{-- You can dynamically calculate this total --}}
          <p class="text-4xl mt-2 text-left">{{ $allBookings->count() }}</p>
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
            {{ $allBookings->where('tanggal_booking', '>=', \Carbon\Carbon::now()->toDateString())->count() }}
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline justify-between">
    {{-- Form Pencarian dan Filter --}}
    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap gap-2">
      <div class="join">
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama MUA" name="search" value="{{ request('search') }}" />
        </label>
        <button type="submit" class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
      </div>

      <select name="filter_layanan" class="select select-bordered">
        <option value="semua" {{ request('filter_layanan') == 'semua' ? 'selected' : '' }}>Semua Layanan</option>
        <option value="Make-up Wedding" {{ request('filter_layanan') == 'Make-up Wedding' ? 'selected' : '' }}>Make-up
          Wedding</option>
        <option value="Make-up Reguler" {{ request('filter_layanan') == 'Make-up Reguler' ? 'selected' : '' }}>Make-up
          Reguler</option>
        <option value="Make-up Class" {{ request('filter_layanan') == 'Make-up Class' ? 'selected' : '' }}>Make-up Class
        </option>
      </select>

      <select name="filter_bulan" class="select select-bordered">
        <option value="all" {{ request('filter_bulan') == 'all' ? 'selected' : '' }}>Semua Bulan</option>
        @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}" {{ request('filter_bulan') == $m ? 'selected' : '' }}>
          {{ \Carbon\Carbon::create()->month($m)->locale('id')->monthName }}</option>
          @endfor
      </select>

      <select name="filter_tahun" class="select select-bordered">
        <option value="all" {{ request('filter_tahun') == 'all' ? 'selected' : '' }}>Semua Tahun</option>
        @for ($y = Carbon\Carbon::now()->year - 5; $y <= Carbon\Carbon::now()->year + 5; $y++)
          <option value="{{ $y }}" {{ request('filter_tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
          @endfor
      </select>

      <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <a href="{{ route('dashboard.appointmentbyadmin') }}" class="btn btn-primary"><i
        class="bi bi-patch-plus-fill"></i>Tambah Pesanan</a>
  </div>

  <div
    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4 overflow-y-auto rounded-box border border-base-content bg-base-200 p-3">
    @forelse ($allBookings as $booking)
    <div class="flex flex-col border-2 text-center overflow-auto rounded-box bg-primary text-primary-content pb-2">
      <div>
        <H3 class="text-2xl font-semibold">
          {{ \Carbon\Carbon::parse($booking->tanggal_booking)->day }}
        </H3>
      </div>
      <p>{{ $booking->nama }}</p>
      <p>{{ $booking->jenis_layanan }}</p>
      <p>{{ \Carbon\Carbon::parse($booking->waktu_booking)->format('H:i') }}</p>
      <p>{{ $booking->nama_mua ?? 'Belum Ditentukan' }}</p>
    </div>
    @empty
    <p class="col-span-full text-center text-gray-500">Tidak ada data booking yang ditemukan.</p>
    @endforelse
  </div>

</x-dashboard-layout>