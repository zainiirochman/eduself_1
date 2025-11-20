@extends('adminlte::page')

@section('title', 'Tambah Data Peminjaman ')

@section('content_header')
    <h1>Tambah Data Peminjaman</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('loans.store') }}" method="POST">
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
                <label for="member_id">Anggota</label>
                <select class="form-control @error('member_id') is-invalid @enderror" id="member_id" name="member_id" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="loan_date">Tanggal Pinjam</label>
                <input type="date" class="form-control @error('loan_date') is-invalid @enderror" 
                       id="loan_date" name="loan_date" 
                       value="{{ old('loan_date', date('Y-m-d')) }}" required>
                @error('loan_date')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="due_date">Tanggal Jatuh Tempo (Otomatis: Tanggal Pinjam + 7 Hari)</label>
                <input type="date" class="form-control" id="due_date" name="due_date" readonly>
                <small class="form-text text-muted">Tanggal jatuh tempo akan otomatis dihitung 7 hari dari tanggal pinjam</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    // Auto calculate tanggal jatuh tempo
    document.getElementById('loan_date').addEventListener('change', function() {
        const tanggalPinjam = new Date(this.value);
        
        if (!isNaN(tanggalPinjam.getTime())) {
            // Tambahkan 7 hari
            tanggalPinjam.setDate(tanggalPinjam.getDate() + 7);
            
            // Format ke YYYY-MM-DD
            const year = tanggalPinjam.getFullYear();
            const month = String(tanggalPinjam.getMonth() + 1).padStart(2, '0');
            const day = String(tanggalPinjam.getDate()).padStart(2, '0');
            
            document.getElementById('due_date').value = `${year}-${month}-${day}`;
        }
    });
    
    // Trigger on page load if loan_date already has value
    window.addEventListener('load', function() {
        const tanggalPinjamInput = document.getElementById('loan_date');
        if (tanggalPinjamInput.value) {
            tanggalPinjamInput.dispatchEvent(new Event('change'));
        }
    });
</script>
@stop