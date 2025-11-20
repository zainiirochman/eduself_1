<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahBuku = \App\Models\Book::count();
        $jumlahAnggota = \App\Models\Member::count();
        $jumlahPeminjaman = \App\Models\Loan::count();
        return view('admin.dashboard', compact('jumlahBuku', 'jumlahAnggota', 'jumlahPeminjaman'));
    }
}