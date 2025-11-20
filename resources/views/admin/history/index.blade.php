@extends('adminlte::page')

@section('title', 'Riwayat Peminjaman')

@section('content_header')
    <h1 class="animate-slide-in">Riwayat Peminjaman</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius:10px;overflow:hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom:3px solid #192334;">
        <h3 class="card-title" style="font-weight:600;"><i class="fas fa-history mr-2"></i>Daftar Riwayat Pengembalian</h3>
        <div class="card-tools">
            <a href="{{ route('history.print') }}?search={{ request('search') }}&month={{ request('month') }}&year={{ request('year') }}" 
               target="_blank" 
               class="btn btn-danger btn-sm btn-animated shadow-sm">
                <i class="fas fa-file-pdf mr-1"></i>Print PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form action="{{ route('history.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-2 mb-2">
                    <select name="month" class="form-control input-animated" onchange="this.form.submit()">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <select name="year" class="form-control input-animated" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-5 mb-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input" placeholder="Cari buku atau anggota..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary btn-search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2 text-right">
                    @if(request('search') || request('month') || request('year'))
                        <button type="button" onclick="window.location.href='{{ route('history.index') }}'" class="btn btn-secondary btn-animated">
                            <i class="fas fa-redo mr-1"></i> Reset
                        </button>
                    @endif
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped animated-table">
                <thead class="bg-light">
                    <tr>
                        <th style="width:60px" class="text-center">No</th>
                        <th>Judul Buku</th>
                        <th>Nama Anggota</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $index => $history)
                        <tr class="table-row-animated" data-aos="fade-up" data-aos-delay="{{ $index * 40 }}">
                            <td class="text-center align-middle">
                                <span class="badge badge-secondary badge-pill">{{ $index + 1 }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="entity-icon mr-3">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <span class="font-weight-500">{{ $history->buku->title ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="entity-icon-small mr-2">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span>{{ $history->member->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="align-middle">{{ \Carbon\Carbon::parse($history->loan_date)->format('d/m/Y') }}</td>
                            <td class="align-middle">{{ \Carbon\Carbon::parse($history->due_date)->format('d/m/Y') }}</td>
                            <td class="align-middle">
                                <span class="badge badge-info px-3 py-2 badge-soft">
                                    {{ \Carbon\Carbon::parse($history->return_date)->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td class="align-middle">
                                @if($history->fine > 0)
                                    <span class="badge badge-danger px-3 py-2 badge-soft">
                                        Rp {{ number_format($history->fine, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="badge badge-success px-3 py-2 badge-soft">Rp 0</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr data-aos="fade-in">
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada riwayat pengembalian</p>
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
.bg-blue-eduself{background:#192334}
.font-weight-500{font-weight:500}

.input-animated{transition:.3s;border:2px solid #e0e0e0;padding:10px 14px;border-radius:8px;height:48px}
.input-animated:focus{border-color:#192334;box-shadow:0 0 0 .15rem rgba(25,35,52,.25);outline:none}

.search-input{transition:.3s;border:2px solid #e0e0e0;padding:10px 15px;border-radius:8px 0 0 8px;font-size:.95rem;height:48px}
.search-input:focus{border-color:#192334;box-shadow:0 0 0 .2rem rgba(25,35,52,.15);outline:none}
.btn-search{border-radius:0 8px 8px 0;padding:10px 20px;transition:.3s;border:2px solid #192334;background:#192334}
.btn-search:hover{background:#87C15A;border-color:#87C15A;transform:scale(1.05)}
.btn-search:active{transform:scale(.96)}

.btn-animated{position:relative;overflow:hidden;transition:.3s}
.btn-animated::before{content:'';position:absolute;top:50%;left:50%;width:0;height:0;border-radius:50%;background:rgba(255,255,255,.35);transform:translate(-50%,-50%);transition:.55s}
.btn-animated:hover::before{width:220px;height:220px}
.btn-animated:hover{transform:translateY(-3px);box-shadow:0 6px 16px rgba(0,0,0,.15)}

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

.badge-pill{transition:.3s;padding:6px 12px;font-size:.75rem}
.table-row-animated:hover .badge-pill{transform:scale(1.1);box-shadow:0 2px 6px rgba(0,0,0,.2)}
.badge-soft{background:#eef2f7;color:#192334;font-weight:500;border-radius:6px}

.empty-state{animation:fadeIn 1s ease-out}
.empty-state i{animation:pulse 2s ease-in-out infinite}

@media (max-width:768px){
 .entity-icon{width:36px;height:36px}
 .entity-icon i{font-size:1rem}
 .entity-icon-small{width:28px;height:28px}
}
</style>
@stop

@section('js')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded',function(){
  AOS.init({duration:600,once:true,easing:'ease-out'});
  
  $('.search-input').on('focus',function(){
    $(this).closest('.input-group').addClass('shadow-sm');
  }).on('blur',function(){
    $(this).closest('.input-group').removeClass('shadow-sm');
  });
});
</script>
@stop