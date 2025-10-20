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
        $month = $request->input('month');
        $year = $request->input('year');
        
        $query = History::with(['buku', 'anggota']);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('buku', function($subQ) use ($search) {
                    $subQ->where('title', 'like', "%{$search}%");
                })
                ->orWhereHas('anggota', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        if ($month) {
            $query->whereMonth('tanggal_kembali', (int)$month);
        }
        
        if ($year) {
            $query->whereYear('tanggal_kembali', (int)$year);
        }
        
        $histories = $query->orderBy('tanggal_kembali', 'desc')->get();
        
        // Debug: tampilkan semua tanggal kembali yang ada
        if ($histories->isEmpty() && ($month || $year)) {
            $allHistories = History::select('tanggal_kembali')->get();
            \Log::info('Available dates:', $allHistories->pluck('tanggal_kembali')->toArray());
        }

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
