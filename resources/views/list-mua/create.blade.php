<x-dashboard-layout>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Data MUA Baru</h1>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
      <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('list-mua.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
      @csrf

      <div class="mb-4">
        <label for="nama_mua" class="block text-gray-700 text-sm font-bold mb-2">Nama MUA:</label>
        <input type="text" name="nama_mua" id="nama_mua" value="{{ old('nama_mua') }}"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-4">
        <label for="no_telp" class="block text-gray-700 text-sm font-bold mb-2">No. Telepon:</label>
        <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          required>
      </div>

      <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Spesialisasi:</label>
        <div class="gap-2">
          <div>
            <input type="checkbox" id="spesialisasi_wedding" name="spesialisasi[]" value="Makeup Wedding"
              class="mr-2 leading-tight" {{ in_array('Makeup Wedding', old('spesialisasi', [])) ? 'checked' : '' }}>
            <label for="spesialisasi_wedding" class="text-gray-700">Makeup Wedding</label>
          </div>
          <div>
            <input type="checkbox" id="spesialisasi_reguler" name="spesialisasi[]" value="Makeup Reguler"
              class="mr-2 leading-tight" {{ in_array('Makeup Reguler', old('spesialisasi', [])) ? 'checked' : '' }}>
            <label for="spesialisasi_reguler" class="text-gray-700">Makeup Reguler</label>
          </div>
          <div>
            <input type="checkbox" id="spesialisasi_class" name="spesialisasi[]" value="Makeup Class"
              class="mr-2 leading-tight"
              {{ in_array('Makeup Class', old('spesialisasi', [])) ? 'checked' : '' }}>
            <label for="spesialisasi_class" class="text-gray-700">Makeup Class</label>
          </div>
        </div>
      </div>

      <!-- <div class="flex items-center justify-between"> -->
        <button type="submit"
          class="btn btn-secondary">
          Simpan MUA
        </button>
        <a href="{{ route('list-mua.index') }}"
          class="btn btn-neutral ml-2">
          Kembali
        </a>
      </div>
    </form>
  </div>
</x-dashboard-layout>