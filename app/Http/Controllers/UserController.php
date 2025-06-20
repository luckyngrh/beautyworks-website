<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string|max:13|min:12|unique:users,no_telp',
            'email' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'password' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login');
    }
}
