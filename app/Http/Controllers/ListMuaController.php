<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListMua; // Pastikan ini diimpor

class ListMuaController extends Controller
{
    /**
     * Menampilkan daftar MUA.
     */
    public function index()
    {
        // Logika untuk menampilkan daftar MUA (jika ada)
        $muas = ListMua::all();
        return view('list-mua.index', compact('muas'));
    }

    /**
     * Menampilkan form untuk membuat MUA baru.
     */
    public function create()
    {
        return view('list-mua.create');
    }

    /**
     * Menyimpan MUA baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_mua' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20', // Sesuaikan validasi no telepon
            'spesialisasi' => 'nullable|array', // Spesialisasi bisa kosong atau array dari checkbox
            'spesialisasi.*' => 'string|max:255', // Setiap item di array spesialisasi harus string
        ]);

        // 2. Menggabungkan spesialisasi dari checkbox menjadi string
        $spesialisasi = $request->input('spesialisasi');
        $spesialisasiString = '';
        if (is_array($spesialisasi) && !empty($spesialisasi)) {
            $spesialisasiString = implode(', ', $spesialisasi);
        }

        // 3. Simpan data ke database
        ListMua::create([
            'nama_mua' => $request->nama_mua,
            'no_telp' => $request->no_telp,
            'spesialisasi' => $spesialisasiString,
        ]);

        // 4. Redirect atau berikan respons sukses
        return redirect()->route('list-mua.create')->with('success', 'Data MUA berhasil ditambahkan!');
        // Atau redirect ke halaman index MUA jika ada:
        // return redirect()->route('list-mua.index')->with('success', 'Data MUA berhasil ditambahkan!');
    }
}