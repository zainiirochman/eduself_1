@extends('adminlte::page')

@section('title', 'Data Peminjaman')

@section('content_header')
    <h1>Data Peminjaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Daftar Peminjaman</h3>
        <div class="card-tools">
            <a href="{{ route('peminjamans.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div>
    </div>
        <div class="card-body">
            <form method="GET" action="{{ route('peminjamans.index') }}" class="mb-3 d-flex">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control mr-2"
                    placeholder="Cari judul buku atau nama anggota..."
                >
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Anggota</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Denda</th>
                            <th>Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $peminjaman)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $peminjaman->buku->title }}</td>
                                <td>{{ $peminjaman->anggota->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/M/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d/M/Y') }}</td>
                                <td>
                                    @if($peminjaman->denda > 0)
                                        <span class="badge badge-danger">Rp. {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
                                        <br>
                                        Terlambat: {{ ceil($peminjaman->denda / 10000) }} Hari
                                    @else
                                        <span class="badge badge-success">Rp. 0</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-success btn-sm" title="Kembalikan">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <form action="{{ route('peminjamans.destroy', $peminjaman->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop