@extends('adminlte::page')

@section('title', 'Tambah Data Peminjaman')

@section('content_header')
    <h1 class="animate-slide-in">Tambah Data Peminjaman</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius:10px;overflow:hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom:3px solid #192334;">
        <h3 class="card-title" style="font-weight:600;"><i class="fas fa-hand-holding-medical mr-2"></i>Form Peminjaman</h3>
        <div class="card-tools">
            <a href="{{ route('loans.index') }}" class="btn btn-light btn-sm btn-animated">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('loans.store') }}" method="POST" class="animate-fade-in">
            @csrf
            <div class="form-group">
                <label for="buku_id" class="font-weight-500">Buku</label>
                <select class="form-control input-animated @error('buku_id') is-invalid @enderror" id="buku_id" name="buku_id" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('buku_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
                @error('buku_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="member_id" class="font-weight-500">Anggota</label>
                <select class="form-control input-animated @error('member_id') is-invalid @enderror" id="member_id" name="member_id" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="loan_date" class="font-weight-500">Tanggal Pinjam</label>
                    <input type="date" class="form-control input-animated @error('loan_date') is-invalid @enderror" 
                           id="loan_date" name="loan_date" 
                           value="{{ old('loan_date', date('Y-m-d')) }}" required>
                    @error('loan_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="due_date" class="font-weight-500">Tanggal Jatuh Tempo</label>
                    <input type="date" class="form-control input-animated" id="due_date" name="due_date" readonly>
                    <small class="form-text text-muted">Otomatis dihitung 7 hari dari tanggal pinjam</small>
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-success btn-animated px-4">
                    <i class="fas fa-save mr-1"></i>Simpan
                </button>
                <a href="{{ route('loans.index') }}" class="btn btn-secondary btn-animated px-4">
                    <i class="fas fa-times mr-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
@keyframes slideIn{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
@keyframes fadeIn{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.animate-slide-in{animation:slideIn .6s ease-out}
.animate-fade-in{animation:fadeIn .7s ease-out}
.bg-blue-eduself{background:#192334}
.font-weight-500{font-weight:500}
.card{transition:.3s}
.card:hover{box-shadow:0 12px 28px rgba(0,0,0,.15)}
.input-animated{transition:.3s;border:2px solid #e0e0e0;padding:10px 14px;border-radius:8px}
.input-animated:focus{border-color:#192334;box-shadow:0 0 0 .15rem rgba(25,35,52,.25);outline:none}
.input-animated[readonly]{background-color:#f8f9fa;cursor:not-allowed}
.btn-animated{position:relative;overflow:hidden;transition:.3s}
.btn-animated::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;background:rgba(255,255,255,.35);transform:translate(-50%,-50%);transition:.55s}
.btn-animated:hover::before{width:220px;height:220px}
.btn-animated:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(0,0,0,.15)}
.gap-2 > * + *{margin-left:.5rem}

@media (max-width:576px){
 .mt-4.d-flex{flex-direction:column}
 .gap-2 > * + *{margin-left:0;margin-top:.5rem}
 .form-row{display:block}
 .form-row .form-group{width:100%}
}
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded',()=> {
    // Auto calculate tanggal jatuh tempo
    const loanDateInput = document.getElementById('loan_date');
    const dueDateInput = document.getElementById('due_date');
    
    loanDateInput.addEventListener('change', function() {
        const tanggalPinjam = new Date(this.value);
        
        if (!isNaN(tanggalPinjam.getTime())) {
            tanggalPinjam.setDate(tanggalPinjam.getDate() + 7);
            
            const year = tanggalPinjam.getFullYear();
            const month = String(tanggalPinjam.getMonth() + 1).padStart(2, '0');
            const day = String(tanggalPinjam.getDate()).padStart(2, '0');
            
            dueDateInput.value = `${year}-${month}-${day}`;
        }
    });
    
    // Trigger on page load
    if (loanDateInput.value) {
        loanDateInput.dispatchEvent(new Event('change'));
    }

    // Form submit handler
    const form = document.querySelector('form');
    form.addEventListener('submit', ()=> {
        const btn = form.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Menyimpan...';
    });
});
</script>
@stop