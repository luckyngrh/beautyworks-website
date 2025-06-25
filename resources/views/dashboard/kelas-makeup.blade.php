<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Daftar Kelas</H1>
  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline">
    <a href="{{ route('dashboard.kelas-makeup') }}" class="btn btn-primary">Kelas Makeup</a>

    <form action="{{ route('dashboard.kelas-makeup') }}" method="GET" class="join">
      <div>
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama Pelanggan" name="search" value="{{ request('search') }}" />
        </label>
      </div>
      <button type="submit" class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
    </form>
  </div>

  @if(session('success'))
  <div id="success-notification" class="bg-green-500 text-white p-2 rounded text-center mb-3">
    {{ session('success') }}
  </div>
  <script>
  setTimeout(function() { // Ganti setTimeoutSuccess dengan setTimeout
    const notification = document.getElementById('success-notification');
    if (notification) {
      notification.remove();
    }
  }, 3000); // 3000ms = 3 detik
  </script>
  @endif

  @if(session('error'))
  <div id="error-notification" class="bg-red-500 text-white p-2 rounded text-center mb-3">
    {{ session('error') }}
  </div>
  <script>
  setTimeout(function() { // Ganti setTimeoutError dengan setTimeout
    const notification = document.getElementById('error-notification');
    if (notification) {
      notification.remove();
    }
  }, 3000); // 3000ms = 3 detik
  </script>
  @endif

  <div class="overflow-x-auto rounded-box border border-base-content bg-base-200">
    <table class="table">
      <!-- head -->
      <thead>
        <tr class="text-center">
          <th>No</th>
          <th>Pelanggan</th>
          <th>MUA</th>
          <th>Keterangan</th>
          <th>Jadwal</th>
          <th>Jam</th>
          <th>Kontak</th>
          <th>Status Pembayaran</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($reservations as $item)
        <tr class="text-center">
          <td>{{ $loop -> iteration }}</td>
          <td>{{ $item->nama}}</td>
          <td>{{ $item->nama_mua ?? 'Belum Ditentukan' }}</td>
          <td>{{ $item->jenis_layanan }}</td>
          <td>{{ \Carbon\Carbon::parse($item->tanggal_reservation)->format('d/m/Y') }}</td>
          <td>{{ \Carbon\Carbon::parse($item->waktu_reservation)->format('H:i') }}</td>
          <td>{{ $item->kontak }}</td>
          <td>
            @if ($item->status == 'Menunggu Konfirmasi')
            <span class="badge badge-warning">{{ $item->status }}</span>
            @elseif ($item->status == 'Menunggu Pembayaran')
            <span class="badge badge-info">{{ $item->status }}</span>
            @elseif ($item->status == 'Sukses')
            <span class="badge badge-success">{{ $item->status }}</span>
            @elseif ($item->status == 'Dibatalkan')
            <span class="badge badge-error">{{ $item->status }}</span>
            @endif
          </td>
          <td class="text-center">
            <a href="{{ route('dashboard.edit-reservation', $item->id_reservation) }}"
              class="btn btn-primary">Detail</a>

            <form class="inline-block" action="{{ route('dashboard.delete-reservation', $item->id_reservation) }}"
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