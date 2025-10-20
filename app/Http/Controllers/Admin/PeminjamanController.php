<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Carbon\Carbon;
use App\Models\History;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['buku', 'anggota']);
        if ($request->search) {
            $query->whereHas('buku', function($q) use ($request) {
                $q->where('title', 'ilike', '%' . $request->search . '%');
            })->orWhereHas('anggota', function($q) use ($request) {
                $q->where('name', 'ilike', '%' . $request->search . '%');
            });
        }
        $peminjamans = $query->get();

        foreach ($peminjamans as $peminjaman) {
            $jatuhTempo = \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo);
            $hariTerlambat = $jatuhTempo->diffInDays(now(), false);
            $denda = $hariTerlambat > 0 ? $hariTerlambat * 10000 : 0;
            $denda = (int) $denda; 
            
            if ($peminjaman->denda !== $denda) {
                $peminjaman->denda = $denda;
                $peminjaman->save();
            }
        }

        return view('admin.peminjamans.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all();
        $anggotas = Anggota::all();
        return view('admin.peminjamans.create', compact('books', 'anggotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'denda' => 'nullable|integer',
        ]);

        // Hitung tanggal jatuh tempo otomatis (tanggal pinjam + 7 hari)
        $tanggalPinjam = \Carbon\Carbon::parse($request->tanggal_pinjam);
        $tanggalJatuhTempo = $tanggalPinjam->copy()->addDays(7);

        DB::beginTransaction();
        
        try {
            // Simpan data peminjaman
            Peminjaman::create([
                'buku_id' => $request->buku_id,
                'anggota_id' => $request->anggota_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'denda' => $request->denda ?? 0,
            ]);

            // Update stock buku menjadi Borrowed
            $buku = Book::find($request->buku_id);
            if ($buku) {
                $buku->stock = 'Borrowed';
                $buku->save();
            }

            DB::commit();

            return redirect()->route('peminjamans.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menambahkan peminjaman: ' . $e->getMessage());
        }
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
    public function edit(Peminjaman $peminjaman)
    {
        $books = Book::all(); // Ambil semua data buku
        $anggotas = Anggota::all(); // Ambil semua data anggota
        return view('admin.peminjamans.edit', compact('peminjaman', 'books', 'anggotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'denda' => 'nullable|integer',
        ]);

        $peminjaman->update($request->all());

        return redirect()->route('admin.peminjamans.index')->with('success', 'Data peminjaman berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjamans.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function return($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        try {
            // 1. Simpan ke tabel history
            $inserted = DB::table('history')->insert([
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $peminjaman->buku_id,
                'anggota_id' => $peminjaman->anggota_id,
                'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $peminjaman->tanggal_jatuh_tempo,
                'tanggal_kembali' => now(),
                'denda' => $peminjaman->denda ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            \Log::info('Insert berhasil:', ['inserted' => $inserted]);
            
            // 2. Update stock buku menjadi Available
            $buku = Book::find($peminjaman->buku_id);
            if ($buku) {
                $buku->stock = 'Available';
                $buku->save();
            }
            
            // 3. Hapus data peminjaman
            $peminjaman->delete();
            
            return redirect()->route('peminjamans.index')->with('success', 'Buku berhasil dikembalikan dan disimpan ke riwayat.');
            
        } catch (\Exception $e) {
            \Log::error('Error saat return buku:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('peminjamans.index')->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }
}
