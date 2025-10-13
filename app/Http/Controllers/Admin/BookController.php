<?php

namespace App\Http\Controllers\Admin;

use Intervention\Image\ImageManager;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::with('category')
            ->when($search, function($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'stock' => 'required|in:Available,Borrowed',
        ]);

        $data = $request->except('cover');

        // if ($request->hasFile('cover')) {
        //     $data['cover'] = file_get_contents($request->file('cover')->getRealPath());
        // }
    
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $manager = new ImageManager(
            new \Intervention\Image\Drivers\Gd\Driver());
            $img = $manager->read($file)->cover(360, 520);
            $path = public_path('image/books/' . $filename);
            $img->save($path);
            // $file->move(public_path('image/books'), $filename);
            $data['cover'] = 'image/books/' . $filename;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
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
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            // 'id' => 'required|string|unique:books,id,' . $book->id,
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'description' => 'nullable|string',
            'stock' => 'required|in:Available,Borrowed',
        ]);

        $book->update($request->all());

        // untuk tipe data longblob
        // if ($request->hasFile('cover')) {
        //     $coverData = file_get_contents($request->file('cover')->getRealPath());
        //     $book->cover = $coverData;
        //     $book->save();
        // }

        // untuk tipe data string (path)
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $manager = new ImageManager(
            new \Intervention\Image\Drivers\Gd\Driver());
            $img = $manager->read($file)->cover(360, 520);
            $path = public_path('image/books/' . $filename);
            $img->save($path);
            // $file->move(public_path('image/books'), $filename);
            $book->cover = 'image/books/' . $filename;
            $book->save();
        }

        return redirect()->route('books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
