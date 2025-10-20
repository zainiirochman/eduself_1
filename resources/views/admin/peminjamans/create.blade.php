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
                <select class="form-control @error('buku_id') is-invalid @enderror" id="buku_id" name="buku_id" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('buku_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
                @error('buku_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="anggota_id">Anggota</label>
                <select class="form-control @error('anggota_id') is-invalid @enderror" id="anggota_id" name="anggota_id" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggotas as $anggota)
                        <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                            {{ $anggota->name }}
                        </option>
                    @endforeach
                </select>
                @error('anggota_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_pinjam">Tanggal Pinjam</label>
                <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                       id="tanggal_pinjam" name="tanggal_pinjam" 
                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                @error('tanggal_pinjam')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo (Otomatis: Tanggal Pinjam + 7 Hari)</label>
                <input type="date" class="form-control" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" readonly>
                <small class="form-text text-muted">Tanggal jatuh tempo akan otomatis dihitung 7 hari dari tanggal pinjam</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('peminjamans.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    // Auto calculate tanggal jatuh tempo
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        const tanggalPinjam = new Date(this.value);
        
        if (!isNaN(tanggalPinjam.getTime())) {
            // Tambahkan 7 hari
            tanggalPinjam.setDate(tanggalPinjam.getDate() + 7);
            
            // Format ke YYYY-MM-DD
            const year = tanggalPinjam.getFullYear();
            const month = String(tanggalPinjam.getMonth() + 1).padStart(2, '0');
            const day = String(tanggalPinjam.getDate()).padStart(2, '0');
            
            document.getElementById('tanggal_jatuh_tempo').value = `${year}-${month}-${day}`;
        }
    });
    
    // Trigger on page load if tanggal_pinjam already has value
    window.addEventListener('load', function() {
        const tanggalPinjamInput = document.getElementById('tanggal_pinjam');
        if (tanggalPinjamInput.value) {
            tanggalPinjamInput.dispatchEvent(new Event('change'));
        }
    });
</script>
@stop