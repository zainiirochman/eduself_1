<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class PerpustakaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $books = Book::all();
        // return view('perpustakaan', compact('books'));
        $search = $request->input('search');
        $books = Book::when($search, function($query, $search) {
        return $query->where('title', 'like', "%{$search}%");
    })->get();

    return view('perpustakaan', compact('books'));
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
}
