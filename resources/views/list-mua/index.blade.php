<x-dashboard-layout>
  <H1 class="text-4xl mb-3">List MUA Beautyworks by Fifi</H1>

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
      <a class="btn btn-primary bi bi-patch-plus-fill" href="{{ route('list-mua.create') }}">Tambah MUA</a>
    </div>
  </div>


  <div class="overflow-x-auto rounded-box border border-base-content bg-base-200">
    <table class="table">
      <!-- head -->
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Speciality</th>
          <th class="text-center">Nomor HP</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <td>1</td>
        <td>Nanda</td>
        <td>Makeup Wedding, Makeup reguler, Makeup Class</td>
        <td class="text-center">0986736566712</td>
        <td class="text-center">
          <a href="" class="btn btn-accent bi bi-pencil-square"></a>

          <form class="inline-block" method="post">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-error bi bi-trash"
              onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"></button>
            {{-- Cek nilai criteria_id --}}
          </form>
        </td>
      </tbody>
    </table>
  </div>
</x-dashboard-layout>