<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Daftar Kelas</H1>
  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline">
    <a href="{{ route('dashboard.kelas-makeup') }}" class="btn btn-primary">Kelas Makeup</a>
    
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
          <th>Keterangan</th>
          <th>Jadwal</th>
          <th>Kontak</th>
          <th>Status</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr class="text-center">
          <td>1</td>
          <td>Nanda</td>
          <td>Fifi</td>
          <td>Private</td>
          <td>20/06/2025</td>
          <td>0986736566712</td>
          <td>Sedang Berlangsung</td>
          <td>Tombol</td>
        </tr>
      </tbody>
    </table>
  </div>
</x-dashboard-layout>