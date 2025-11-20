@extends('adminlte::page')

@section('title', 'Data Kategori')

@section('content_header')
    <h1 class="animate-slide-in">Data Kategori</h1>
@stop

@section('content')
<div class="card shadow-lg animate-fade-in" style="border-radius: 10px; overflow: hidden;">
    <div class="card-header bg-blue-eduself text-white" style="border-bottom: 3px solid #192334;">
        <h3 class="card-title" style="font-weight: 600;"><i class="fas fa-list-alt mr-2"></i>Daftar Kategori</h3>
        <div class="card-tools">
            <a href="{{ route('categories.create') }}" class="btn btn-light btn-sm btn-animated shadow-sm">
                <i class="fas fa-plus-circle mr-1"></i>Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-animated" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-animated" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form method="GET" action="{{ route('categories.index') }}" class="mb-4 search-form">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control search-input"
                    placeholder="Cari nama kategori..."
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
                        <th style="width: 60px" class="text-center">No</th>
                        <th>Nama Kategori</th>
                        <th style="width: 150px" class="text-center">Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $key => $category)
                    <tr class="table-row-animated" data-aos="fade-up" data-aos-delay="{{ $key * 50 }}">
                        <td class="text-center align-middle">
                            <span class="badge badge-secondary badge-pill">{{ $categories->firstItem() + $key }}</span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="category-icon mr-3">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <span class="font-weight-500">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group-action">
                                <a href="{{ route('categories.edit', $category->id) }}" 
                                   class="btn btn-sm btn-success btn-action" 
                                   data-toggle="tooltip" 
                                   title="Edit Kategori">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Yakin hapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger btn-action" 
                                            data-toggle="tooltip" 
                                            title="Hapus Kategori">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr data-aos="fade-in">
                        <td colspan="3" class="text-center py-5">
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
            {{ $categories->links() }}
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <style>
        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes iconRotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.6s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        /* Card Enhancements */
        .card {
            transition: all 0.3s ease;
        }

        /* Alert Animations */
        .alert-animated {
            animation: fadeIn 0.5s ease-out;
        }

        /* Button Animations */
        .btn-animated {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-animated::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-animated:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-animated:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .btn-animated:active {
            transform: translateY(0);
        }

        /* Search Form - DIPERBAIKI */
        .search-form {
            animation: fadeIn 0.6s ease-out 0.2s backwards;
            max-width: 500px;
        }

        .search-input {
            transition: all 0.3s ease;
            border: 2px solid #e0e0e0;
            padding: 10px 15px;
            border-radius: 8px 0 0 8px;
            font-size: 0.95rem;
            height: 48px;
        }

        .search-input:focus {
            border-color: #192334;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
            outline: none;
        }

        .btn-search {
            border-radius: 0 8px 8px 0;
            padding: 10px 20px;
            transition: all 0.3s ease;
            border: 2px solid #192334;
            background: #192334;
        }

        .btn-search:hover {
            background: #87C15A;
            border-color: #87C15A;
            transform: scale(1.05);
        }

        .btn-search i {
            font-size: 1rem;
        }

        .btn-search:active {
            transform: scale(0.98);
        }

        /* Table Enhancements */
        .animated-table {
            border-radius: 8px;
            overflow: hidden;
        }

        .animated-table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #dee2e6;
            background: #f8f9fa;
        }

        .table-row-animated {
            transition: all 0.3s ease;
        }

        .table-row-animated:hover {
            background-color: #f8f9fa !important;
            transform: translateX(3px);
            box-shadow: -3px 0 0 #192334, 0 2px 8px rgba(0,0,0,0.08);
        }

        /* Category Icon - DIPERBAIKI */
        .category-icon {
            width: 40px;
            height: 40px;
            background: #192334;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s ease;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .category-icon i {
            color: #fff;
            font-size: 1.2rem;
            transition: transform 0.4s ease;
        }

        .table-row-animated:hover .category-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);
        }

        .table-row-animated:hover .category-icon i {
            animation: iconRotate 0.6s ease;
        }

        /* Action Buttons - DIPERBAIKI */
        .btn-group-action {
            display: inline-flex;
            gap: 8px;
        }

        .btn-action {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-action i {
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .btn-action:hover::before {
            width: 100px;
            height: 100px;
        }

        .btn-success.btn-action {
            background: #87C15A;
            box-shadow: 0 2px 8px rgba(17, 153, 142, 0.3);
        }

        .btn-success.btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(17, 153, 142, 0.5);
        }

        .btn-danger.btn-action {
            background: #f45c43;
            box-shadow: 0 2px 8px rgba(235, 51, 73, 0.3);
        }

        .btn-danger.btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(235, 51, 73, 0.5);
        }

        .btn-action:active {
            transform: translateY(0);
        }

        /* Empty State */
        .empty-state {
            animation: fadeIn 1s ease-out;
        }

        .empty-state i {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Badge */
        .badge-pill {
            transition: all 0.3s ease;
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .table-row-animated:hover .badge-pill {
            transform: scale(1.1);
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        /* Pagination */
        .pagination-wrapper {
            animation: fadeIn 0.8s ease-out 0.4s backwards;
        }

        .pagination .page-link {
            transition: all 0.2s ease;
            border-radius: 6px;
            margin: 0 2px;
        }

        .pagination .page-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Gradient Header */
        .bg-gradient-primary {
            background: #192334;
        }

        .bg-blue-eduself {
            background: #192334;
        }

        /* Font Weight Helper */
        .font-weight-500 {
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .search-form {
                max-width: 100%;
            }

            .btn-group-action {
                flex-direction: column;
                gap: 4px;
            }
            
            .category-icon {
                width: 35px;
                height: 35px;
            }

            .category-icon i {
                font-size: 1rem;
            }
        }
    </style>
@stop

@section('js')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 600,
                once: true,
                easing: 'ease-out'
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip({
                boundary: 'window',
                placement: 'top'
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Add ripple effect to action buttons
            $('.btn-action').on('click', function(e) {
                const button = $(this);
                const ripple = $('<span class="ripple"></span>');
                
                const rect = button[0].getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                ripple.css({
                    left: x + 'px',
                    top: y + 'px'
                });
                
                button.append(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });

            // Smooth scroll for pagination
            $('.pagination a').on('click', function(e) {
                $('html, body').animate({
                    scrollTop: $('.card').offset().top - 20
                }, 500);
            });

            // Search input animation
            $('.search-input').on('focus', function() {
                $(this).closest('.input-group').addClass('shadow-sm');
            }).on('blur', function() {
                $(this).closest('.input-group').removeClass('shadow-sm');
            });

            // Add loading state to search button
            $('.search-form').on('submit', function() {
                const btn = $(this).find('.btn-search');
                const originalContent = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i>');
                btn.prop('disabled', true);
                
                // Reset jika ada error (fallback)
                setTimeout(() => {
                    btn.html(originalContent);
                    btn.prop('disabled', false);
                }, 5000);
            });
        });

        // Add ripple CSS dynamically
        const style = document.createElement('style');
        style.textContent = `
            .ripple {
                position: absolute;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple-animation 0.6s ease-out;
                pointer-events: none;
            }
            
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
@stop