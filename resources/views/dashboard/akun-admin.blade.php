<x-dashboard-layout>
  <H1 class="text-4xl mb-3">Akun Administrator Beautyworks by Fifi</H1>

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
      <a class="btn btn-primary bi bi-patch-plus-fill" href="{{ route('dashboard.create-admin') }}">Tambah admin</a>
    </div>
  </div>


  <div class="overflow-x-auto rounded-box border border-base-content bg-base-200">
    <table class="table">
      <!-- head -->
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th class="text-center">Nomor HP</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr class="hover:bg-base-300">
          <td>{{ $loop->iteration }}</td>
          <td>{{ $user->nama }}</td>
          <td>{{ $user->email }}</td>
          <td class="text-center">{{ $user->no_telp }}</td>
          <td class="text-center">
            <a href="" class="btn btn-accent bi bi-pencil-square"></a>

            <form class="inline-block" action="{{ route('dashboard.destroy-admin', $user -> id) }}" method="post">
              @method('delete')
              @csrf
              <button type="submit" class="btn btn-error bi bi-trash" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"></button>
              <!-- <p>ID: {{ $user -> id }}</p>  -->
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-dashboard-layout>