<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function showRegister()
    {
        return view('register_pengguna');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'jk'       => 'required|in:Laki-laki,Perempuan',
            'prodi'    => 'required|in:Pend. Teknologi Informasi,Sistem Informasi,Teknik Informatika',
            'hp'       => 'required|unique:anggotas,hp',
            'password' => 'required|string|min:6',
        ]);

        Anggota::create([
            'name'     => $request->name,
            'jk'       => $request->jk,
            'prodi'    => $request->prodi,
            'hp'       => $request->hp,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login_pengguna')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Tampilkan form login
    public function showLogin()
    {
        return view('login_pengguna');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'hp'       => 'required',
            'password' => 'required',
        ]);

        $anggota = Anggota::where('hp', $request->hp)->first();

        if ($anggota && Hash::check($request->password, $anggota->password)) {
            session(['anggota_id' => $anggota->id]);
            return redirect('/')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['hp' => 'Nomor HP atau password salah']);
    }

    // Logout
    public function logout()
    {
        session()->forget('anggota_id');
        return redirect('/login_pengguna');
    }
}
