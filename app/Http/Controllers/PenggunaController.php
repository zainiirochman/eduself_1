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

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'jk'       => 'required|in:Laki-laki,Perempuan',
            'prodi'    => 'required|in:Pend. Teknologi Informasi,Sistem Informasi,Teknik Informatika',
            'hp'       => 'required|unique:anggotas,hp',
            'email'    => ['nullable','email','regex:/^[^@]+@mhs\.unesa\.ac\.id$/i','unique:anggotas,email'],
            'password' => 'required|string|min:6',
        ], [
            'email.regex' => 'Email harus berakhiran @mhs.unesa.ac.id',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        Anggota::create([
            'name'     => $request->name,
            'jk'       => $request->jk,
            'prodi'    => $request->prodi,
            'hp'       => $request->hp,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login_pengguna')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function showLogin()
    {
        return view('login_pengguna');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $anggota = Anggota::where('email', $request->email)->first();

        if ($anggota && Hash::check($request->password, $anggota->password)) {
            session(['anggota_id' => $anggota->id]);
            return redirect('/')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        session()->forget('anggota_id');
        return redirect('/login_pengguna');
    }
}
