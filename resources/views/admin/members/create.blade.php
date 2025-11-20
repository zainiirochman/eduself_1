@extends('adminlte::page')

@section('title', 'Tambah Anggota')

@section('content_header')
    <h1>Tambah Anggota Baru</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Anggota</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ old('gender', $member->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender', $member->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <select name="prodi" id="prodi" class="form-control @error('prodi') is-invalid @enderror" required>
                    <option value="">-- Pilih Program Studi --</option>
                    <option value="Pend. Teknologi Informasi" {{ old('prodi', $member->prodi ?? '') == 'Pend. Teknologi Informasi' ? 'selected' : '' }}>Pend. Teknologi Informasi</option>
                    <option value="Sistem Informasi" {{ old('prodi', $member->prodi ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Teknik Informatika" {{ old('prodi', $member->prodi ?? '') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                </select>
                @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" name="hp" class="form-control @error('hp') is-invalid @enderror" value="{{ old('hp') }}">
                @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@stop