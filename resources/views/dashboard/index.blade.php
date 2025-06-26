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

  <div class="flex gap-4 mb-4 items-baseline justify-end">
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-primary m-1"><i class="bi bi-patch-plus-fill"></i>Tambah Pesanan</div>
      <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
        <li><a href="{{ route('dashboard.weddingbyadmin') }}">Make-up Wedding</a></li>
        <li><a href="{{ route('dashboard.regulerbyadmin') }}">Make-up Reguler</a></li>
        <li><a href="{{ route('dashboard.classbyadmin') }}">Make-up Class</a></li>
      </ul>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4 overflow-y-auto rounded-box border border-base-content bg-base-200 p-3">
    {{-- Form Pencarian dan Filter --}}
    <form action="{{ route('dashboard') }}" method="GET" class="col-span-7">
      <div class="join w-[20%]">
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama MUA" name="search" value="{{ request('search') }}" />
        </label>
        <button type="submit" class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
      </div>

      <select name="filter_layanan" class="select select-bordered w-[20%]">
        <option value="semua" {{ request('filter_layanan') == 'semua' ? 'selected' : '' }}>Semua Layanan</option>
        <option value="Make-up Wedding" {{ request('filter_layanan') == 'Make-up Wedding' ? 'selected' : '' }}>Make-up
          Wedding</option>
        <option value="Make-up Reguler" {{ request('filter_layanan') == 'Make-up Reguler' ? 'selected' : '' }}>Make-up
          Reguler</option>
        <option value="Make-up Class" {{ request('filter_layanan') == 'Make-up Class' ? 'selected' : '' }}>Make-up Class
        </option>
      </select>

      <select name="filter_bulan" class="select select-bordered w-[20%]">
        @for ($m = 1; $m <= 12; $m++) <option value="{{ $m }}"
          {{ (request('filter_bulan', date('n')) == $m) ? 'selected' : '' }}>
          {{ \Carbon\Carbon::create()->month($m)->locale('id')->monthName }}</option>
          @endfor
      </select>

      <select name="filter_tahun" class="select select-bordered w-[20%]">
        @for ($y = Carbon\Carbon::now()->year - 5; $y <= Carbon\Carbon::now()->year + 5; $y++)
          <option value="{{ $y }}" {{ (request('filter_tahun', date('Y')) == $y) ? 'selected' : '' }}>{{ $y }}</option>
          @endfor
      </select>

      <button type="submit" class="btn btn-primary w-[18%]">Filter</button>
    </form>

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