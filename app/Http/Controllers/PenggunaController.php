<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
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
            'gender'       => 'required|in:Laki-laki,Perempuan',
            'prodi'    => 'required|in:Pend. Teknologi Informasi,Sistem Informasi,Teknik Informatika',
            'hp'       => 'required|unique:anggotas,hp',
            'email'    => ['nullable','email','regex:/^[^@]+@mhs\.unesa\.ac\.id$/i','unique:anggotas,email'],
            'password' => 'required|string|min:6',
        ], [
            'email.regex' => 'Email harus berakhiran @mhs.unesa.ac.id',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        Member::create([
            'name'     => $request->name,
            'gender'   => $request->gender,
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

        $member = Member::where('email', $request->email)->first();

        if ($member && Hash::check($request->password, $member->password)) {
            session(['member_id' => $member->id]);
            return redirect('/')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout()
    {
        session()->forget('member_id');
        return redirect('/login_pengguna');
    }
}
