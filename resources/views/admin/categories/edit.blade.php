@extends('adminlte::page')

@section('title', 'Edit Kategori')

@section('content_header')
    <h1 class="animate-slide-in">Edit Kategori</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius:10px;overflow:hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom:3px solid #192334;">
        <h3 class="card-title" style="font-weight:600;">
            <i class="fas fa-folder-open mr-2"></i>Form Edit Kategori
        </h3>
        <div class="card-tools">
            <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm btn-animated">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="animate-fade-in">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name" class="font-weight-500">Nama Kategori</label>
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control input-animated @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}"
                       placeholder="Masukkan nama kategori"
                       required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mt-4 d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-success btn-animated px-4">
                    <i class="fas fa-save mr-1"></i>Update
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-animated px-4">
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
.btn-animated{position:relative;overflow:hidden;transition:.3s}
.btn-animated::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;background:rgba(255,255,255,.35);transform:translate(-50%,-50%);transition:.55s}
.btn-animated:hover::before{width:220px;height:220px}
.btn-animated:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(0,0,0,.15)}
.input-animated{transition:.3s;border:2px solid #e0e0e0;padding:10px 14px;border-radius:8px}
.input-animated:focus{border-color:#87C15A;box-shadow:0 0 0 .15rem rgba(135,193,90,.25)}
.font-weight-500{font-weight:500}
.card{transition:.3s}
.card:hover{box-shadow:0 12px 28px rgba(0,0,0,.15)}
.gap-2 > * + *{margin-left:.5rem}
@media (max-width:576px){
 .mt-4.d-flex{flex-direction:column}
 .gap-2 > * + *{margin-left:0;margin-top:.5rem}
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