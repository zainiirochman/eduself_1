@extends('adminlte::page')

@section('title', 'Riwayat Peminjaman')

@section('content_header')
    <h1>Riwayat Peminjaman</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Riwayat Pengembalian Buku</h3>
        <div class="card-tools">
            <form action="{{ route('history.index') }}" method="GET">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Jatuh Tempo</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $index => $history)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $history->buku->title ?? '-' }}</td>
                            <td>{{ $history->anggota->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->tanggal_pinjam)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->tanggal_kembali)->format('d/m/Y H:i') }}</td>
                            <td>Rp {{ number_format($history->denda, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada riwayat pengembalian</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop