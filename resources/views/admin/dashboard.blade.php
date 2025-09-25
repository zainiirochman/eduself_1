@extends('adminlte::page')

{{-- Judul Halaman --}}
@section('title', 'EduSelf')

{{-- Judul Konten (Opsional) --}}
@section('content_header')
    <h1>Dashboard EduSelf</h1>
@stop

{{-- Konten Utama --}}
@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow" style="background:#48a9c5;color:#fff;">
                <div class="card-body text-center">
                    <span style="font-size:2rem;"><i class="fas fa-book"></i></span>
                    <div style="font-size:1.3rem;font-weight:500;margin-top:8px;">Jumlah Buku</div>
                    <div style="font-size:2.5rem;font-weight:bold;margin-top:8px;">{{ $jumlahBuku }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="background:#4caf50;color:#fff;">
                <div class="card-body text-center">
                    <span style="font-size:2rem;"><i class="fas fa-user-friends"></i></span>
                    <div style="font-size:1.3rem;font-weight:500;margin-top:8px;">Jumlah Anggota</div>
                    <div style="font-size:2.5rem;font-weight:bold;margin-top:8px;">{{ $jumlahAnggota }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow" style="background:#fbc02d;color:#222;">
                <div class="card-body text-center">
                    <span style="font-size:2rem;"><i class="fas fa-book-reader"></i></span>
                    <div style="font-size:1.3rem;font-weight:500;margin-top:8px;">Jumlah Peminjaman Aktif</div>
                    <div style="font-size:2.5rem;font-weight:bold;margin-top:8px;">{{ $jumlahPeminjaman }}</div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- CSS Tambahan (Opsional) --}}
@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

{{-- JS Tambahan (Opsional) --}}
@section('js')
    <script> console.log('Halaman Dashboard!'); </script>
@stop