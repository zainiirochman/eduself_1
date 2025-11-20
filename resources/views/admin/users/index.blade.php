@extends('adminlte::page')

@section('title', 'Kelola Admin')

@section('content_header')
    <h1 class="animate-slide-in">Kelola Admin</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius:10px;overflow:hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom:3px solid #192334;">
        <h3 class="card-title" style="font-weight:600;"><i class="fas fa-user-shield mr-2"></i>Daftar Admin</h3>
        <div class="card-tools">
            <a href="{{ route('users.create') }}" class="btn btn-light btn-sm btn-animated shadow-sm">
                <i class="fas fa-user-plus mr-1"></i>Tambah Admin
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
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-animated" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped animated-table">
                <thead class="bg-light">
                    <tr>
                        <th style="width:60px" class="text-center">No</th>
                        <th>Nama Admin</th>
                        <th>Email</th>
                        <th style="width:160px" class="text-center">Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $key => $user)
                    <tr class="table-row-animated" data-aos="fade-up" data-aos-delay="{{ $key * 40 }}">
                        <td class="text-center align-middle">
                            <span class="badge badge-secondary badge-pill">{{ $users->firstItem() + $key }}</span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="entity-icon mr-3">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <span class="font-weight-500">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-info px-3 py-2 badge-soft">{{ $user->email }}</span>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group-action">
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="btn btn-sm btn-success btn-action"
                                   data-toggle="tooltip"
                                   title="Edit Admin">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger btn-action"
                                            data-toggle="tooltip"
                                            title="Hapus Admin">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr data-aos="fade-in">
                        <td colspan="4" class="text-center py-5">
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
    <div class="card-footer clearfix bg-light">
        <div class="pagination-wrapper">
            {{ $users->links() }}
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

.animated-table{border-radius:8px;overflow:hidden}
.animated-table thead th{font-weight:600;text-transform:uppercase;font-size:.75rem;letter-spacing:.5px;border-bottom:2px solid #dee2e6;background:#f8f9fa}
.table-row-animated{transition:.3s}
.table-row-animated:hover{background:#f8f9fa !important;transform:translateX(3px);box-shadow:-3px 0 0 #192334,0 2px 8px rgba(0,0,0,.08)}

.entity-icon{width:42px;height:42px;background:#192334;border-radius:10px;display:flex;align-items:center;justify-content:center;transition:.4s;box-shadow:0 2px 8px rgba(25,35,52,.35)}
.entity-icon i{color:#fff;font-size:1.1rem;transition:transform .4s}
.table-row-animated:hover .entity-icon{transform:scale(1.1) rotate(5deg)}
.table-row-animated:hover .entity-icon i{animation:iconRotate .6s ease}

.btn-group-action{display:inline-flex;gap:8px}
.btn-action{width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;transition:.3s;border:none;position:relative;overflow:hidden}
.btn-action i{font-size:.9rem;position:relative;z-index:1}
.btn-action::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;background:rgba(255,255,255,.3);transform:translate(-50%,-50%);transition:.4s}
.btn-action:hover::before{width:110px;height:110px}
.btn-success.btn-action{background:#87C15A;box-shadow:0 2px 8px rgba(135,193,90,.35)}
.btn-success.btn-action:hover{transform:translateY(-3px);box-shadow:0 4px 12px rgba(135,193,90,.55)}
.btn-danger.btn-action{background:#f45c43;box-shadow:0 2px 8px rgba(244,92,67,.35)}
.btn-danger.btn-action:hover{transform:translateY(-3px);box-shadow:0 4px 12px rgba(244,92,67,.55)}

.btn-animated{position:relative;overflow:hidden;transition:.3s}
.btn-animated::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;background:rgba(255,255,255,.35);transform:translate(-50%,-50%);transition:.55s}
.btn-animated:hover::before{width:220px;height:220px}
.btn-animated:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(0,0,0,.15)}

.badge-pill{transition:.3s;padding:6px 12px;font-size:.75rem}
.table-row-animated:hover .badge-pill{transform:scale(1.1);box-shadow:0 2px 6px rgba(0,0,0,.2)}
.badge-soft{background:#eef2f7;color:#192334;font-weight:500;border-radius:6px}

.empty-state{animation:fadeIn 1s ease-out}
.empty-state i{animation:pulse 2s ease-in-out infinite}

.pagination-wrapper{animation:fadeIn .8s ease-out .4s backwards}
.pagination .page-link{transition:.2s;border-radius:6px;margin:0 2px}
.pagination .page-link:hover{transform:translateY(-2px);box-shadow:0 2px 8px rgba(0,0,0,.1)}

@media (max-width:768px){
 .btn-group-action{flex-direction:column;gap:4px}
 .entity-icon{width:36px;height:36px}
 .entity-icon i{font-size:1rem}
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
  $('.pagination a').on('click',function(){
    $('html,body').animate({scrollTop:$('.card').offset().top-20},500);
  });
});
const style=document.createElement('style');
style.textContent=`.ripple{position:absolute;width:20px;height:20px;border-radius:50%;background:rgba(255,255,255,.6);transform:scale(0);animation:ripple-animation .6s ease-out;pointer-events:none}@keyframes ripple-animation{to{transform:scale(4);opacity:0}}`;
document.head.appendChild(style);
</script>
@stop