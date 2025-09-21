<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class RegisterPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'prodi' => 'required|in:Pend. Teknologi Informasi,Sistem Informasi, Teknik Informatika',
            'hp' => 'required|string|max:15',
            'password' => 'required|string|min:8',
        ]);
        Anggota::create([
            'name' => $request->name,
            'jk' => $request->jk,
            'prodi' => $request->prodi,
            'hp' => $request->hp,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/login_pengguna')->with('success', 'Registrasi berhasil, silakan login.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
