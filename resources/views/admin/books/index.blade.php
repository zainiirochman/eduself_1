@extends('adminlte::page')

@section('title', 'Data Buku')

@section('content_header')
    <h1>Data Buku</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Buku</h3>
        <div class="card-tools">
            <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Kolom Pencarian -->
        <form method="GET" action="{{ route('books.index') }}" class="mb-3 d-flex">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control mr-2"
                placeholder="Cari judul buku..."
            >
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>ID Buku</th>
                    <th>Judul Buku</th>
                    <th>Kategori</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th style="width: 75px">Kelola</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $key => $book)
                <tr>
                    <td>{{ $books->firstItem() + $key }}</td>
                    <td>{{ $book->book_id }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ $book->year }}</td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pen"></i></a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $books->links() }}
    </div>
</div>
@stop