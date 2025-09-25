@extends('adminlte::page')

@section('title', 'Tambah Anggota')

@section('content_header')
    <h1>Tambah Anggota Baru</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('anggotas.store') }}" method="POST">
            @csrf
            <!-- <div class="form-group">
                <label for="name">Nama Anggota</label>
                <input type="text" name="name" value="{{ old('name') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div> -->
            <div class="form-group">
                <label>Nama Anggota</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="jk">Jenis Kelamin</label>
                <select name="jk" id="jk" class="form-control @error('jk') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ old('jk', $anggota->jk ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jk', $anggota->jk ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jk') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="prodi">Program Studi</label>
                <select name="prodi" id="jk" class="form-control @error('prodi') is-invalid @enderror" required>
                    <option value="">-- Pilih Program Studi --</option>
                    <option value="Pend. Teknologi Informasi" {{ old('prodi', $anggota->prodi ?? '') == 'Pend. Teknologi Informasi' ? 'selected' : '' }}>Pend. Teknologi Informasi</option>
                    <option value="Sistem Informasi" {{ old('prodi', $anggota->prodi ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                    <option value="Teknik Informatika" {{ old('prodi', $anggota->prodi ?? '') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                </select>
                @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <!-- <div class="form-group">
                <label for="hp">Nomor HP</label>
                <input type="text" name="hp" value="{{ old('hp') }}">
                @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div> -->
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
            <a href="{{ route('anggotas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@stop