@extends('adminlte::page')

@section('title', 'Riwayat Peminjaman')

@section('content_header')
    <h1>Riwayat Peminjaman</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Riwayat Pengembalian Buku</h3>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form action="{{ route('history.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <select name="month" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="year" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Cari buku atau anggota..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    @if(request('search') || request('month') || request('year'))
                        <a href="{{ route('history.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    @endif
                    <a href="{{ route('history.print') }}?search={{ request('search') }}&month={{ request('month') }}&year={{ request('year') }}" 
                       target="_blank" 
                       class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Print PDF
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
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