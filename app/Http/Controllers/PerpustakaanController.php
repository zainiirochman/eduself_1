<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;
use App\Models\Loan;

class PerpustakaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $books = Book::with('category')
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%")->orWhere('author', 'like', "%{$search}%")->orWhere('year', 'like', "%{$search}%"))
            ->when($category, fn($q) => $q->whereHas('category', fn($qc) => $qc->where('name', $category)))
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('perpustakaan', compact('books','category','search'));
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
        //
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

    public function borrow(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $memberId = session('member_id');
        if (!$memberId) {
            return response()->json(['message' => 'Harus login untuk meminjam buku.'], 403);
        }

        $book = Book::find($request->book_id);
        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        // support both numeric stock or enum values ('Available' / 'Borrowed')
        $stockVal = $book->stock;
        $available = false;

        if (is_numeric($stockVal)) {
            $available = (int)$stockVal > 0;
        } else {
            // treat enum/text case-insensitive; consider 'available' as available
            $available = strtolower((string)$stockVal) === 'available';
        }

        if (! $available) {
            return response()->json(['message' => 'Buku saat ini tidak tersedia.'], 422);
        }

        $p = new Loan();
        $p->member_id = $memberId;
        $p->buku_id = $book->id;
        $p->loan_date = Carbon::now();
        $p->due_date = Carbon::now()->addDays(7);
        $p->save();

        // update books.stock:
        if (is_numeric($stockVal)) {
            $book->stock = max(0, (int)$stockVal - 1);
        } else {
            // column is enum('Borrowed','Available') — set to 'Borrowed'
            $book->stock = 'Borrowed';
        }
        $book->save();

        return response()->json([
            'message' => 'Berhasil meminjam buku.',
            'loan_id' => $p->id,
            'new_stock' => $book->stock,
        ]);
    }
}
