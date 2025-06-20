<x-dashboard-layout>
  <fieldset class="fieldset bg-base-200 border-1 rounded-box mx-auto p-4 w-fit items-center text-center">
    <h1 class="text-center text-4xl">Tambah Daftar MUA</h1>

    <label class="label">Nama</label>
    <input type="text" class="input w-full" placeholder="Nama" />

    <label class="label">No HP</label>
    <p class="validator-hint hidden">Must be 10 digits</p>
    <label class="input validator w-full">
      <input type="tel" class="tabular-nums" required placeholder="Masukkan Nomor Telepon" pattern="[0-9]*"
        minlength="12" maxlength="13" title="Must be 12 or 13 digits" name="no_hp" value="{{ old('no_hp') }}" />
    </label>
    @error('no_hp')
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror

    <label class="label">Speciality</label>
    <label class="label">
      <input type="checkbox" checked="false" class="checkbox" />Make-Up Wedding
      <input type="checkbox" checked="false" class="checkbox" />Make-Up Reguler
      <input type="checkbox" checked="false" class="checkbox" />Make-Up Class
    </label>

    <button class="btn btn-secondary mt-4 bi bi-check-lg">Simpan</button>
    <a href="{{ route('list-mua.index') }}" class="btn btn-neutral mt-4 bi bi-arrow-return-left">Kembali</a>
</fieldset>
</x-dashboard-layout>