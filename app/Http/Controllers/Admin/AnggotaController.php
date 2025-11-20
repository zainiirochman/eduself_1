<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $anggotas = Anggota::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.anggotas.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.anggotas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'prodi' => 'required|in:Pend. Teknologi Informasi,Sistem Informasi, Teknik Informatika',
            'hp' => 'required|string|max:15',
            'password' => 'required|string|min:6',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        Anggota::create($validated);

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil ditambahkan.');
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
    public function edit(Anggota $anggota)
    {
        return view('admin.anggotas.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'prodi' => 'required|in:Pend. Teknologi Informasi,Sistem Informasi,Teknik Informatika',
            'hp' => 'required|string|max:15',
        ]);

        $anggota->update($request->all());

        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota)
    {
        $anggota->delete();
        return redirect()->route('anggotas.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
