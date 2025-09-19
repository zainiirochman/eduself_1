@extends('adminlte::page')

@section('title', 'Data Anggota')

@section('content_header')
    <h1>Data Anggota</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Anggota</h3>
        <div class="card-tools">
            <a href="{{ route('anggotas.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form method="GET" action="{{ route('anggotas.index') }}" class="mb-3 d-flex">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control mr-2"
                placeholder="Cari nama anggota..."
            >
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Nama Anggota</th>
                    <th>Jenis Kelamin</th>
                    <th>Program Studi</th>
                    <th>Nomor HP</th>
                    <th style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggotas as $key => $anggota)
                <tr>
                    <td>{{ $anggotas->firstItem() + $key }}</td>
                    <td>{{ $anggota->name }}</td>
                    <td>{{ $anggota->jk }}</td>
                    <td>{{ $anggota->prodi }}</td>
                    <td>{{ $anggota->hp}}</td>
                    <td>
                        <a href="{{ route('anggotas.edit', $anggota->id) }}" class="btn btn-warning btn-xs">Edit</a>
                        <form action="{{ route('anggotas.destroy', $anggota->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $anggotas->links() }}
    </div>
</div>
@stop