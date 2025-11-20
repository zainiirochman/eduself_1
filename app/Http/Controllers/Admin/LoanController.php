<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Member;
use App\Models\Loan;
use Carbon\Carbon;
use App\Models\History;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Loan::with(['buku', 'member']);
        if ($request->search) {
            $query->whereHas('buku', function($q) use ($request) {
                $q->where('title', 'ilike', '%' . $request->search . '%');
            })->orWhereHas('member', function($q) use ($request) {
                $q->where('name', 'ilike', '%' . $request->search . '%');
            });
        }
        $loans = $query->get();

        foreach ($loans as $loan) {
            $jatuhTempo = \Carbon\Carbon::parse($loan->due_date);
            $hariTerlambat = $jatuhTempo->diffInDays(now(), false);
            $denda = $hariTerlambat > 0 ? $hariTerlambat * 10000 : 0;
            $fine = (int) $denda; 
            
            if ($loan->fine !== $denda) {
                $loan->fine = $denda;
                $loan->save();
            }
        }

        return view('admin.loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all();
        $members = Member::all();
        return view('admin.loans.create', compact('books', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'loan_date' => 'required|date',
            'fine' => 'nullable|integer',
        ]);

        // Hitung tanggal jatuh tempo otomatis (tanggal pinjam + 7 hari)
        $tanggalPinjam = \Carbon\Carbon::parse($request->loan_date);
        $tanggalJatuhTempo = $tanggalPinjam->copy()->addDays(7);

        DB::beginTransaction();
        
        try {
            Loan::create([
                'buku_id' => $request->buku_id,
                'member_id' => $request->member_id,
                'loan_date' => $request->loan_date,
                'due_date' => $tanggalJatuhTempo,
                'fine' => $request->denda ?? 0,
            ]);

            $buku = Book::find($request->buku_id);
            if ($buku) {
                $buku->stock = 'Borrowed';
                $buku->save();
            }

            DB::commit();

            return redirect()->route('loans.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
            
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
    public function edit(Loan $loan)
    {
        $books = Book::all();
        $members = Member::all(); 
        return view('admin.loans.edit', compact('loan', 'books', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loans)
    {
        $request->validate([
            'buku_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date',
            'fine' => 'nullable|integer',
        ]);

        $loan->update($request->all());

        return redirect()->route('admin.loans.index')->with('success', 'Data peminjaman berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function return($id)
    {
        $loan = Loan::findOrFail($id);
        
        try {
            // 1. Simpan ke tabel history
            $inserted = DB::table('history')->insert([
                'loan_id' => $loan->id,
                'buku_id' => $loan->buku_id,
                'member_id' => $loan->member_id,
                'loan_date' => $loan->loan_date,
                'due_date' => $loan->due_date,
                'return_date' => now(),
                'fine' => $loan->fine ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            \Log::info('Insert berhasil:', ['inserted' => $inserted]);
            
            $buku = Book::find($loan->buku_id);
            if ($buku) {
                $buku->stock = 'Available';
                $buku->save();
            }
            
            // 3. Hapus data peminjaman
            $loan->delete();
            
            return redirect()->route('loans.index')->with('success', 'Buku berhasil dikembalikan dan disimpan ke riwayat.');
            
        } catch (\Exception $e) {
            \Log::error('Error saat return buku:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('loans.index')->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }
}
