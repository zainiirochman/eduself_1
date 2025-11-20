@extends('adminlte::page')

@section('title', 'Tambah Data Buku')

@section('content_header')
    <h1 class="animate-slide-in">Tambah Data Buku</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius:10px;overflow:hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom:3px solid #192334;">
        <h3 class="card-title" style="font-weight:600;"><i class="fas fa-book-medical mr-2"></i>Form Buku</h3>
        <div class="card-tools">
            <a href="{{ route('books.index') }}" class="btn btn-light btn-sm btn-animated">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="animate-fade-in">
            @csrf
            <div class="form-group">
                <label class="font-weight-500">Judul Buku</label>
                <input type="text" name="title" class="form-control input-animated @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul" required>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-500">Kategori</label>
                <select name="category_id" class="form-control input-animated @error('category_id') is-invalid @enderror" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id')==$category->id?'selected':'' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-500">Pengarang</label>
                    <input type="text" name="author" class="form-control input-animated @error('author') is-invalid @enderror" value="{{ old('author') }}" placeholder="Nama pengarang">
                    @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-500">Penerbit</label>
                    <input type="text" name="publisher" class="form-control input-animated @error('publisher') is-invalid @enderror" value="{{ old('publisher') }}" placeholder="Nama penerbit">
                    @error('publisher') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="font-weight-500">Tahun Terbit</label>
                    <input type="number" name="year" class="form-control input-animated @error('year') is-invalid @enderror" value="{{ old('year') }}" placeholder="YYYY">
                    @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-md-8">
                    <label class="font-weight-500">Cover Buku (Max 1MB)</label>
                    <input type="file" name="cover" class="form-control input-animated @error('cover') is-invalid @enderror" accept="image/*">
                    @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="font-weight-500">Deskripsi</label>
                <textarea name="description" rows="3" class="form-control input-animated @error('description') is-invalid @enderror" placeholder="Deskripsi singkat">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="font-weight-500">Ketersediaan</label>
                <select name="stock" class="form-control input-animated @error('stock') is-invalid @enderror" required>
                    <option value="Available" {{ old('stock')=='Available'?'selected':'' }}>Available</option>
                    <option value="Borrowed" {{ old('stock')=='Borrowed'?'selected':'' }}>Borrowed</option>
                </select>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mt-4 d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-success btn-animated px-4">
                    <i class="fas fa-save mr-1"></i>Simpan
                </button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary btn-animated px-4">
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
.btn-animated{position:relative;overflow:hidden;transition:.3s}
.btn-animated::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;background:rgba(255,255,255,.35);transform:translate(-50%,-50%);transition:.55s}
.btn-animated:hover::before{width:220px;height:220px}
.btn-animated:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(0,0,0,.15)}
.gap-2 > * + *{margin-left:.5rem}

/* --- FIX FILE INPUT COLLISION --- */
input[type="file"].input-animated{
    padding:8px 14px;           /* reduce vertical padding so button not pressed to border */
    line-height:1.2;
}
input[type="file"].input-animated::-webkit-file-upload-button{
    margin-right:12px;
    padding:6px 14px;
    border:0;
    border-radius:6px;
    background:#192334;
    color:#fff;
    cursor:pointer;
    transition:.3s;
}
input[type="file"].input-animated::-webkit-file-upload-button:hover{
    background:#87C15A;
}
input[type="file"].input-animated::file-selector-button{
    margin-right:12px;
    padding:6px 14px;
    border:0;
    border-radius:6px;
    background:#192334;
    color:#fff;
    cursor:pointer;
    transition:.3s;
}
input[type="file"].input-animated::file-selector-button:hover{
    background:#87C15A;
}
/* Prevent text overlap */
input[type="file"].input-animated{
    overflow:hidden;
    position:relative;
}

/* Mobile */
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
  const form=document.querySelector('form');
  form.addEventListener('submit',()=>{
    const btn=form.querySelector('button[type="submit"]');
    btn.disabled=true;
    btn.innerHTML='<i class="fas fa-spinner fa-spin mr-1"></i>Menyimpan...';
  });
});
</script>
@stop