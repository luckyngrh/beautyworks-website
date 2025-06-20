<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Gunakan App\Models\User
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:13|min:12|unique:users,no_telp',
            'email' => 'required|string|max:255|unique:users', // Tambahkan unique rule for email
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed', // Tambahkan min length dan confirmed rule
        ]);

        User::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set default role to 'user' for new registrations
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function indexadmin()
    {
        $users = User::where('role', 'admin')->get();
        return view('dashboard.akun-admin', compact('users'));
    }

    public function createadmin()
    {
        return view('dashboard.create-admin');
    }

    public function storeadmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:13|min:12|unique:users,no_telp',
            'email' => 'required|string|max:255|unique:users', // Tambahkan unique rule for email
        ]);

        User::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make('beautyworks123'),
            'role' => 'admin',
        ]);

        return redirect()->route('dashboard.store-admin')->with('success', 'Akun admin berhasil ditambahkan!');
    }

    public function editadmin($id)
    {
        $admin = User::findOrFail($id);
        return view('dashboard.edit-admin', compact('admin'));
    }

    /**
     * Memperbarui MUA yang ada di database.
     */
    public function updateadmin(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'password' => 'string|max:255',
        ]);

        $admin = User::findOrFail($id);
        $admin->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => $request->password ? Hash::make($request->password) : $admin->password, // Hanya update password jika diisi
            'role' => 'admin', // Pastikan role tetap admin
        ]);

        return redirect()->route('dashboard.akun-admin')->with('success', 'Data MUA berhasil diperbarui!');
    }

    public function destroyadmin($id)
    {
        // Criteria::destroy($criteria->id);
        $admin = User::findOrFail($id); // Pastikan model kriteria Anda benar
        $admin->delete();
        return redirect()->route('dashboard.akun-admin')->with('success', 'Data berhasil dihapus!');
    }
}