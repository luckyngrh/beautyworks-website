<x-layout>
<div class="flex flex-col items-center h-screen gap-4 pt-6">
  <h1 class="text-3xl">Masuk ke Beautyworks</h1>
  <img src="{{ asset('images/logo.png') }}" alt="Logo">
  <form action="/login" method="post">
    @csrf
    <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
      <label class="label">Email</label>
      <input type="email" class="input" placeholder="Email" name="email" value="{{ old('email') }}" required/>
      @error('email')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    
      <label class="label">Password</label>
      <input type="password" class="input" placeholder="Password" name="password" required/>
      @error('password')
          <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
      @enderror
    
      <button class="btn btn-primary mt-4">Login</button>
      <p>Belum punya akun?</p>
      <a href="{{ route('daftar-akun') }}" class="btn btn-outline">Daftar Akun</a>
    </fieldset>
  </form>
</div>
</x-layout>