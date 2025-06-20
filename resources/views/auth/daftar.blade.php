<x-layout>
  <div class="flex flex-col items-center h-screen gap-4 pt-6">
    <h1 class="text-3xl">Daftar Beautyworks</h1>
    <img src="{{ asset('images/logo.png') }}" alt="Logo">
    <form action="/daftar-akun/store" method="post">
      @csrf
      <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
        <!-- <legend class="fieldset-legend">Login</legend> -->

        <label class="label">Nama</label>
        <input type="text" class="input" placeholder="Masukkan Nama" name="nama" required/>

        <label class="label">No Telp</label>
        <p class="validator-hint hidden">Must be 10 digits</p>
        <label class="input validator">
          <input type="tel" class="tabular-nums" required placeholder="Masukkan Nomor Telepon" pattern="[0-9]*"
            minlength="12" maxlength="13" title="Must be 12 or 13 digits" name="no_telp" />
        </label>

        <label class="label">Email</label>
        <input type="email" class="input" placeholder="Masukkan Email" name="email" required/>

        <label class="label">Alamat</label>
        <textarea 
          name="alamat"
          rows="4"
          class="textarea"
          placeholder="Masukkan Alamat"
          required>
        </textarea>

        <label class="label">Password</label>
        <input type="password" class="input" placeholder="Masukkan Password" name="password" required/>

        <button type="submit" class="btn btn-primary mt-4">Daftar</button>
      </fieldset>
    </form>
  </div>
</x-layout>