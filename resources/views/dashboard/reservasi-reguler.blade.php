<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Daftar Reservasi</H1>
  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline">
    <div class="flex flex-col md:flex-row gap-4 mb-4 border-2 p-4 rounded-2xl max-w-fit">
      <a href="{{ route('dashboard.reservasi-reguler') }}" class="btn btn-primary">Reguler</a>
      <a href="{{ route('dashboard.reservasi-wedding') }}" class="btn btn-outline">Wedding</a>
    </div>

    <div class="join">
      <div>
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama" required />
        </label>
      </div>
      <button class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
    </div>
  </div>

  <div class="overflow-x-auto rounded-box border border-base-content bg-base-200">
    <table class="table">
      <!-- head -->
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
          <td>{{ $item->user->nama}}</td>
          <td>{{ $item->mua->nama_mua ?? 'NA' }}</td>
          <td>{{ $item->jenis_layanan }}</td>
          <td>{{ \Carbon\Carbon::parse($item->tanggal_appointment)->format('d/m/Y') }}</td>
          <td>{{ \Carbon\Carbon::parse($item->waktu_appointment)->format('H:i') }}</td>
          <td>{{ $item->kontak }}</td>
          <td>{{ $item->status }}</td>
          <td class="text-center">
            <a href="" class="btn btn-primary">Detail</a>
          </td>
        </tr>
        @endforeach
        <tr class="text-center">
          <td>1</td>
          <td>Nanda</td>
          <td>Fifi</td>
          <td>Make-Up Reguler</td>
          <td>20/06/2025</td>
          <td>0986736566712</td>
          <td>Sedang Berlangsung</td>
          <td>Tombol</td>
        </tr>
      </tbody>
    </table>
  </div>
</x-dashboard-layout>