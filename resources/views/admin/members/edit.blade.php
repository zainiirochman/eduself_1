@extends('adminlte::page')

@section('title', 'Edit Anggota')

@section('content_header')
    <h1 class="animate-slide-in">Edit Data Anggota</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius:10px;overflow:hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom:3px solid #192334;">
        <h3 class="card-title" style="font-weight:600;">
            <i class="fas fa-user-edit mr-2"></i>Form Edit Anggota
        </h3>
        <div class="card-tools">
            <a href="{{ route('members.index') }}" class="btn btn-light btn-sm btn-animated">
                <i class="fas fa-arrow-left mr-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('members.update', $member->id) }}" method="POST" class="animate-fade-in">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="font-weight-500">Nama Anggota</label>
                <input type="text" name="name"
                       class="form-control input-animated @error('name') is-invalid @enderror"
                       value="{{ old('name', $member->name) }}" placeholder="Masukkan nama lengkap" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-500">Jenis Kelamin</label>
                    <select name="gender"
                            class="form-control input-animated @error('gender') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('gender', $member->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $member->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-500">Program Studi</label>
                    <select name="prodi"
                            class="form-control input-animated @error('prodi') is-invalid @enderror" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <option value="Pend. Teknologi Informasi" {{ old('prodi', $member->prodi ?? '') == 'Pend. Teknologi Informasi' ? 'selected' : '' }}>Pend. Teknologi Informasi</option>
                        <option value="Sistem Informasi" {{ old('prodi', $member->prodi ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option value="Teknik Informatika" {{ old('prodi', $member->prodi ?? '') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    </select>
                    @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-500">Email Unesa</label>
                    <input type="email" name="email"
                           class="form-control input-animated @error('email') is-invalid @enderror"
                           value="{{ old('email', $member->email) }}" placeholder="contoh@mhs.unesa.ac.id" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-500">Nomor HP</label>
                    <input type="text" name="hp"
                           class="form-control input-animated @error('hp') is-invalid @enderror"
                           value="{{ old('hp', $member->hp) }}" placeholder="08xxxxxxxxxx" required>
                    @error('hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-success btn-animated px-4">
                    <i class="fas fa-save mr-1"></i>Update
                </button>
                <a href="{{ route('members.index') }}" class="btn btn-secondary btn-animated px-4">
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
    btn.innerHTML='<i class="fas fa-spinner fa-spin mr-1"></i>Memperbarui...';
  });
});
</script>
@stop