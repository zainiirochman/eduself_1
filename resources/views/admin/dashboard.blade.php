@extends('adminlte::page')

{{-- Judul Halaman --}}
@section('title', 'EduSelf')

{{-- Judul Konten (Opsional) --}}
@section('content_header')
    <h1>Dashboard EduSelf</h1>
@stop

{{-- Konten Utama --}}
@section('content')
    <p>Selamat datang di halaman admin!</p>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Contoh Card</h3>
        </div>
        <div class="card-body">
            Ini adalah isi dari card. Anda bisa mulai menempatkan komponen Anda di sini.
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