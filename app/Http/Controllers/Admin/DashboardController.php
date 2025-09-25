<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBuku = \App\Models\Book::count();
        $jumlahAnggota = \App\Models\Anggota::count();
        $jumlahPeminjaman = \App\Models\Peminjaman::count();
        return view('admin.dashboard', compact('jumlahBuku', 'jumlahAnggota', 'jumlahPeminjaman'));
    }
}