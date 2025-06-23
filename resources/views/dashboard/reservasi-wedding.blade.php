<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Daftar Reservasi</H1>
  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline">
    <div class="flex flex-col md:flex-row gap-4 mb-4 border-2 p-4 rounded-2xl max-w-fit">
      <a href="{{ route('dashboard.reservasi-reguler') }}" class="btn btn-outline">Reguler</a>
      <a href="{{ route('dashboard.reservasi-wedding') }}" class="btn btn-primary">Wedding</a>
    </div>

    <form action="{{ route('dashboard.reservasi-wedding') }}" method="GET" class="join"> {{-- --}}
      <div>
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama" name="search" value="{{ request('search') }}" /> {{-- --}}
        </label>
      </div>
      <button type="submit" class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
      {{-- --}}
    </form>
  </div>

  <div class="overflow-x-auto rounded-box border border-base-content bg-base-200">
    <table class="table">
      <thead>
        <tr class="text-center">
          <th>No</th>
          <th>Pelanggan</th>
          <th>MUA</th>
          <th>Jenis Layanan</th>
          <th>Tanggal</th>
          <th>Waktu</th>
          <th>Kontak</th>
          <th>Status</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($appointments as $item)
        <tr class="text-center">
          <td>{{ $loop -> iteration }}</td>
          <td>{{ $item->nama}}</td>
          <td>{{ $item->mua->nama_mua ?? 'Belum Ditentukan' }}</td>
          <td>{{ $item->jenis_layanan }}</td>
          <td>{{ \Carbon\Carbon::parse($item->tanggal_appointment)->format('d/m/Y') }}</td>
          <td>{{ \Carbon\Carbon::parse($item->waktu_appointment)->format('H:i') }}</td>
          <td>{{ $item->kontak }}</td>
          <td>
            @if ($item->status == 'Menunggu Konfirmasi')
            <span class="badge badge-warning">{{ $item->status }}</span>
            @elseif ($item->status == 'Diproses')
            <span class="badge badge-info">{{ $item->status }}</span>
            @elseif ($item->status == 'Selesai')
            <span class="badge badge-success">{{ $item->status }}</span>
            @elseif ($item->status == 'Dibatalkan')
            <span class="badge badge-error">{{ $item->status }}</span>
            @endif
          </td>
          <td class="text-center">
            <a href="{{ route('dashboard.edit-appointment', $item->id_appointment) }}"
              class="btn btn-primary">Detail</a>

            <form class="inline-block" action="{{ route('dashboard.delete-appointment', $item->id_appointment) }}"
              method="post">
              @method('delete')
              @csrf
              <button type="submit" class="btn btn-error"
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus Data</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-dashboard-layout>