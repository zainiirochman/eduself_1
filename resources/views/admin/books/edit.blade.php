@extends('adminlte::page')

@section('title', 'Edit Data Buku')

@section('content_header')
    <h1>Edit Data Buku</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- <div class="form-group">
                <label>ID Buku</label>
                <input type="text" name="book_id" class="form-control @error('book_id') is-invalid @enderror" value="{{ old('book_id', $book->book_id) }}">
                @error('book_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div> -->
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $book->title) }}">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Pengarang</label>
                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $book->author) }}">
                @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher', $book->publisher) }}">
                @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Tahun Terbit</label>
                <input type="number" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $book->year) }}">
                @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Upload Cover Buku (Max. 1 MB)</label>
                <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror">
                @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}">
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="stock">Ketersediaan</label>
                <select name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" required>
                    <!-- <option value="">-- Pilih Ketersediaan --</option> -->
                    <option value="Available" {{ old('stock', $book->stock ?? '') == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Borrowed" {{ old('stock', $book->stock ?? '') == 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
                </select>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@stop