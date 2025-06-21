<x-dashboard-layout>
  <H1 class="text-4xl mb-3">List MUA Beautyworks by Fifi</H1>

  <div class="flex flex-col md:flex-row gap-4 mb-4 items-baseline justify-between">
    {{-- Form Pencarian --}}
    <form action="{{ route('list-mua.index') }}" method="GET" class="join">
      <div>
        <label class="input validator join-item">
          <input type="text" placeholder="Cari Nama" name="search" value="{{ request('search') }}" />
        </label>
      </div>
      <button type="submit" class="btn btn-primary join-item bi bi-search-heart-fill text-accent text-xl"></button>
    </form>

    <div>
      <a class="btn btn-primary bi bi-patch-plus-fill" href="{{ route('list-mua.create') }}">Tambah MUA</a>
    </div>
  </div>


  <div class="overflow-x-auto rounded-box border border-base-content bg-base-200">
    <table class="table">
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
        @foreach ($muas as $mua)
        <tr class="hover:bg-base-300">
          <td>{{ $loop->iteration }}</td>
          <td>{{ $mua->nama_mua }}</td>
          <td>{{ $mua->spesialisasi }}</td>
          <td class="text-center">{{ $mua->no_telp }}</td>
          <td class="text-center">
            <a href="{{ route('list-mua.edit', $mua->id_mua) }}" class="btn btn-accent bi bi-pencil-square"></a>

            <form class="inline-block" action="{{ route('list-mua.destroy', $mua->id_mua) }}" method="post">
              @method('delete')
              @csrf
              <button type="submit" class="btn btn-error bi bi-trash"
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-dashboard-layout>