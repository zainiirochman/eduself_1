<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\History;
use Illuminate\Http\Request;

class PeminjamanAktifController extends Controller
{
    public function index(Request $request)
    {
        $memberId = session('member_id');
        
        if (!$memberId) {
            return redirect()->route('login_pengguna')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $loans = Loan::with(['buku'])
            ->where('member_id', $memberId)
            ->orderBy('created_at', 'desc')
            ->get();

        $histories = History::with('buku')
            ->where('member_id', $memberId)
            ->orderBy('return_date', 'desc')
            ->get();
        
        return view('pinjaman_aktif', compact('loans', 'histories'));
    }
}
