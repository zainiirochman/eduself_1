<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanAktifController extends Controller
{
    public function index(Request $request)
    {
        $anggotaId = session('anggota_id');
        
        if (!$anggotaId) {
            return redirect()->route('login_pengguna')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $peminjamans = Peminjaman::with(['buku'])
            ->where('anggota_id', $anggotaId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('pinjaman_aktif', compact('peminjamans'));
    }
}
