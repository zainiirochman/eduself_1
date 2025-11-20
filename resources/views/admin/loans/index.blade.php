@extends('adminlte::page')

@section('title', 'Data Peminjaman')

@section('content_header')
    <h1 class="animate-slide-in">Data Peminjaman</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius:10px;overflow:hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom:3px solid #192334;">
        <h3 class="card-title" style="font-weight:600;"><i class="fas fa-exchange-alt mr-2"></i>Daftar Peminjaman</h3>
        <div class="card-tools">
            <a href="{{ route('loans.create') }}" class="btn btn-light btn-sm btn-animated shadow-sm">
                <i class="fas fa-plus-circle mr-1"></i>Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-animated" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <form method="GET" action="{{ route('loans.index') }}" class="mb-4 search-form">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control search-input"
                    placeholder="Cari judul buku atau nama anggota..."
                >
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary btn-search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped animated-table">
                <thead class="bg-light">
                    <tr>
                        <th style="width:60px" class="text-center">No</th>
                        <th>Buku</th>
                        <th>Anggota</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Denda</th>
                        <th style="width:160px" class="text-center">Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $key => $loan)
                    <tr class="table-row-animated" data-aos="fade-up" data-aos-delay="{{ $key * 40 }}">
                        <td class="text-center align-middle">
                            <span class="badge badge-secondary badge-pill">{{ $loop->iteration }}</span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="entity-icon mr-3">
                                    <i class="fas fa-book"></i>
                                </div>
                                <span class="font-weight-500">{{ $loan->buku->title }}</span>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="entity-icon-small mr-2">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span>{{ $loan->member->name }}</span>
                            </div>
                        </td>
                        <td class="align-middle">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d/M/Y') }}</td>
                        <td class="align-middle">{{ \Carbon\Carbon::parse($loan->due_date)->format('d/M/Y') }}</td>
                        <td class="align-middle">
                            @if($loan->fine > 0)
                                <span class="badge badge-danger px-3 py-2 badge-soft">Rp {{ number_format($loan->fine, 0, ',', '.') }}</span>
                                <br>
                                <small class="text-muted">Terlambat: {{ ceil($loan->fine / 10000) }} Hari</small>
                            @else
                                <span class="badge badge-success px-3 py-2 badge-soft">Rp 0</span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group-action">
                                <form action="{{ route('loans.return', $loan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm btn-success btn-action"
                                            onclick="return confirm('Konfirmasi pengembalian buku?')"
                                            data-toggle="tooltip"
                                            title="Kembalikan Buku">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger btn-action"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            data-toggle="tooltip"
                                            title="Hapus Data">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr data-aos="fade-in">
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Data tidak ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<style>
@keyframes slideIn{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
@keyframes fadeIn{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.05)}}
@keyframes iconRotate{from{transform:rotate(0)}to{transform:rotate(360deg)}}
.animate-slide-in{animation:slideIn .6s ease-out}
.animate-fade-in{animation:fadeIn .8s ease-out}

.card{transition:.3s}
.alert-animated{animation:fadeIn .5s ease-out}

.bg-blue-eduself{background:#192334}
.font-weight-500{font-weight:500}

.search-form{animation:fadeIn .6s ease-out .2s backwards;max-width:600px}
.search-input{transition:.3s;border:2px solid #e0e0e0;padding:10px 15px;border-radius:8px 0 0 8px;font-size:.95rem;height:48px}
.search-input:focus{border-color:#192334;box-shadow:0 0 0 .2rem rgba(25,35,52,.15);outline:none}
.btn-search{border-radius:0 8px 8px 0;padding:10px 20px;transition:.3s;border:2px solid #192334;background:#192334}
.btn-search:hover{background:#87C15A;border-color:#87C15A;transform:scale(1.05)}
.btn-search:active{transform:scale(.96)}

.animated-table{border-radius:8px;overflow:hidden}
.animated-table thead th{font-weight:600;text-transform:uppercase;font-size:.75rem;letter-spacing:.5px;border-bottom:2px solid #dee2e6;background:#f8f9fa}
.table-row-animated{transition:.3s}
.table-row-animated:hover{background:#f8f9fa !important;transform:translateX(3px);box-shadow:-3px 0 0 #192334,0 2px 8px rgba(0,0,0,.08)}

.entity-icon{width:42px;height:42px;background:#192334;border-radius:10px;display:flex;align-items:center;justify-content:center;transition:.4s;box-shadow:0 2px 8px rgba(25,35,52,.35)}
.entity-icon i{color:#fff;font-size:1.1rem;transition:transform .4s}
.table-row-animated:hover .entity-icon{transform:scale(1.1) rotate(5deg)}
.table-row-animated:hover .entity-icon i{animation:iconRotate .6s ease}

.entity-icon-small{width:32px;height:32px;background:#87C15A;border-radius:8px;display:flex;align-items:center;justify-content:center;transition:.3s;box-shadow:0 2px 6px rgba(135,193,90,.3)}
.entity-icon-small i{color:#fff;font-size:.9rem}
.table-row-animated:hover .entity-icon-small{transform:scale(1.1)}

.btn-group-action{display:inline-flex;gap:8px}
.btn-action{width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;transition:.3s;border:none;position:relative;overflow:hidden}
.btn-action i{font-size:.9rem;position:relative;z-index:1}
.btn-action::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;background:rgba(255,255,255,.3);transform:translate(-50%,-50%);transition:.4s}
.btn-action:hover::before{width:110px;height:110px}
.btn-success.btn-action{background:#87C15A;box-shadow:0 2px 8px rgba(135,193,90,.35)}
.btn-success.btn-action:hover{transform:translateY(-3px);box-shadow:0 4px 12px rgba(135,193,90,.55)}
.btn-danger.btn-action{background:#f45c43;box-shadow:0 2px 8px rgba(244,92,67,.35)}
.btn-danger.btn-action:hover{transform:translateY(-3px);box-shadow:0 4px 12px rgba(244,92,67,.55)}

.badge-pill{transition:.3s;padding:6px 12px;font-size:.75rem}
.table-row-animated:hover .badge-pill{transform:scale(1.1);box-shadow:0 2px 6px rgba(0,0,0,.2)}
.badge-soft{background:#eef2f7;color:#192334;font-weight:500;border-radius:6px}

.empty-state{animation:fadeIn 1s ease-out}
.empty-state i{animation:pulse 2s ease-in-out infinite}

.pagination-wrapper{animation:fadeIn .8s ease-out .4s backwards}
.pagination .page-link{transition:.2s;border-radius:6px;margin:0 2px}
.pagination .page-link:hover{transform:translateY(-2px);box-shadow:0 2px 8px rgba(0,0,0,.1)}

@media (max-width:768px){
 .search-form{max-width:100%}
 .btn-group-action{flex-direction:column;gap:4px}
 .entity-icon{width:36px;height:36px}
 .entity-icon i{font-size:1rem}
 .entity-icon-small{width:28px;height:28px}
 .btn-action{width:38px;height:38px}
}
</style>
@stop

@section('js')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  AOS.init({duration:600,once:true,easing:'ease-out'});
  $('[data-toggle="tooltip"]').tooltip({boundary:'window',placement:'top'});
  setTimeout(()=>{$('.alert').fadeOut('slow');},5000);
  $('.btn-action').on('click',function(e){
    const b=$(this);
    const r=$('<span class="ripple"></span>');
    const rect=b[0].getBoundingClientRect();
    const x=e.clientX-rect.left;
    const y=e.clientY-rect.top;
    r.css({left:x+'px',top:y+'px'});
    b.append(r);
    setTimeout(()=>r.remove(),600);
  });
  $('.search-input').on('focus',function(){
    $(this).closest('.input-group').addClass('shadow-sm');
  }).on('blur',function(){
    $(this).closest('.input-group').removeClass('shadow-sm');
  });
  $('.search-form').on('submit',function(){
    const btn=$(this).find('.btn-search');
    const orig=btn.html();
    btn.html('<i class="fas fa-spinner fa-spin"></i>');
    btn.prop('disabled',true);
    setTimeout(()=>{btn.html(orig);btn.prop('disabled',false);},5000);
  });
});
const style=document.createElement('style');
style.textContent=`.ripple{position:absolute;width:20px;height:20px;border-radius:50%;background:rgba(255,255,255,.6);transform:scale(0);animation:ripple-animation .6s ease-out;pointer-events:none}@keyframes ripple-animation{to{transform:scale(4);opacity:0}}`;
document.head.appendChild(style);
</script>
@stop