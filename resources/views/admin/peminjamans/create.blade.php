@extends('adminlte::page')

@section('title', 'Tambah Data Peminjaman')

@section('content_header')
    <h1>Tambah Data Peminjaman</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('peminjamans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="buku_id">Buku</label>
                <select class="form-control" id="buku_id" name="buku_id" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="anggota_id">Anggota</label>
                <select class="form-control" id="anggota_id" name="anggota_id" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggotas as $anggota)
                        <option value="{{ $anggota->id }}">{{ $anggota->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
            </div>

            <div class="form-group">
                <label for="tanggal_jatuh_tempo">Jatuh Tempo</label>
                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop