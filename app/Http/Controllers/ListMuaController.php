<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListMua; // Pastikan ini diimpor

class ListMuaController extends Controller
{
    /**
     * Menampilkan daftar MUA.
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        // Logika untuk menampilkan daftar MUA (jika ada)
        $query = ListMua::query(); // Gunakan query builder

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_mua', 'like', '%' . $search . '%');
        }

        $muas = $query->get(); // Ambil data setelah filter

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

    public function edit($id_mua)
    {
        $mua = ListMua::findOrFail($id_mua);
        return view('list-mua.edit', compact('mua'));
    }

    /**
     * Memperbarui MUA yang ada di database.
     */
    public function update(Request $request, $id_mua)
    {
        $request->validate([
            'nama_mua' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'spesialisasi' => 'nullable|array',
            'spesialisasi.*' => 'string|max:255',
        ]);

        $mua = ListMua::findOrFail($id_mua);

        $spesialisasi = $request->input('spesialisasi');
        $spesialisasiString = '';
        if (is_array($spesialisasi) && !empty($spesialisasi)) {
            $spesialisasiString = implode(', ', $spesialisasi);
        }

        $mua->update([
            'nama_mua' => $request->nama_mua,
            'no_telp' => $request->no_telp,
            'spesialisasi' => $spesialisasiString,
        ]);

        return redirect()->route('list-mua.index')->with('success', 'Data MUA berhasil diperbarui!');
    }

    public function destroy($id_mua)
    {
        // Criteria::destroy($criteria->id);
        $mua = ListMua::findOrFail($id_mua); // Pastikan model kriteria Anda benar
        $mua->delete();
        return redirect()->route('list-mua.index')->with('success', 'Data berhasil dihapus!');
    }

}