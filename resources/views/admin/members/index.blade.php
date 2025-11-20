@extends('adminlte::page')

@section('title', 'Data Member')

@section('content_header')
    <h1>Data Member</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Member</h3>
        <div class="card-tools">
            <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
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
        <form method="GET" action="{{ route('members.index') }}" class="mb-3 d-flex">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                class="form-control mr-2"
                placeholder="Cari nama member..."
            >
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Nama Member</th>
                    <th>Nomor HP</th>
                    <th>Program Studi</th>
                    <th>Email</th>
                    <th style="width: 75px">Kelola</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $key => $member)
                <tr>
                    <td>{{ $members->firstItem() + $key }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->hp }}</td>
                    <td>{{ $member->prodi }}</td>
                    <td>{{ $member->email}}</td>
                    <td>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-success btn-xs"><i class="fa fa-pen"></i></a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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
        {{ $members->links() }}
    </div>
</div>
@stop