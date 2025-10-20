<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $histories = History::with(['buku', 'anggota'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('buku', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })
                ->orWhereHas('anggota', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal_kembali', 'desc')
            ->get();

        return view('admin.history.index', compact('histories'));
    }

    public function print(Request $request)
    {
        $search = $request->input('search');
        
        $histories = History::with(['buku', 'anggota'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('buku', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })
                ->orWhereHas('anggota', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('tanggal_kembali', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.history.print', compact('histories'));
        
        return $pdf->download('laporan-riwayat-peminjaman-'.date('Y-m-d').'.pdf');
    }
}
