@extends('adminlte::page')

{{-- Judul Halaman --}}
@section('title', 'EduSelf')

{{-- Judul Konten (Opsional) --}}
@section('content_header')
    <h1 class="animate-fade-in">Dashboard EduSelf</h1>
@stop

{{-- Konten Utama --}}
@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow dashboard-card" style="background:#48a9c5;color:#fff;" data-aos="fade-up" data-aos-delay="0">
                <div class="card-body text-center">
                    <span style="font-size:2rem;" class="icon-bounce"><i class="fas fa-book"></i></span>
                    <div style="font-size:1.3rem;font-weight:500;margin-top:8px;">Jumlah Buku</div>
                    <div style="font-size:2.5rem;font-weight:bold;margin-top:8px;" class="counter" data-target="{{ $jumlahBuku }}">0</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow dashboard-card" style="background:#4caf50;color:#fff;" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body text-center">
                    <span style="font-size:2rem;" class="icon-bounce"><i class="fas fa-user-friends"></i></span>
                    <div style="font-size:1.3rem;font-weight:500;margin-top:8px;">Jumlah Anggota</div>
                    <div style="font-size:2.5rem;font-weight:bold;margin-top:8px;" class="counter" data-target="{{ $jumlahAnggota }}">0</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow dashboard-card" style="background:#fbc02d;color:#222;" data-aos="fade-up" data-aos-delay="200">
                <div class="card-body text-center">
                    <span style="font-size:2rem;" class="icon-bounce"><i class="fas fa-book-reader"></i></span>
                    <div style="font-size:1.3rem;font-weight:500;margin-top:8px;">Jumlah Peminjaman Aktif</div>
                    <div style="font-size:2.5rem;font-weight:bold;margin-top:8px;" class="counter" data-target="{{ $jumlahPeminjaman }}">0</div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- CSS Tambahan (Opsional) --}}
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .dashboard-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }
        
        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            transition: left 0.5s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.2) !important;
        }
        
        .dashboard-card:hover::before {
            left: 100%;
        }
        
        .icon-bounce {
            display: inline-block;
            animation: bounce 2s infinite;
        }
        
        .dashboard-card:hover .icon-bounce {
            animation: bounce 0.6s ease;
        }
        
        .counter {
            display: inline-block;
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover .counter {
            transform: scale(1.1);
        }
    </style>
@stop

{{-- JS Tambahan (Opsional) --}}
@section('js')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Halaman Dashboard!');
            
            // Initialize AOS (Animate On Scroll)
            AOS.init({
                duration: 800,
                once: true,
                easing: 'ease-out'
            });
            
            // Counter animation for numbers
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const duration = 1500; // ms
                const step = target / (duration / 16); // 60fps
                let current = 0;
                
                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                // Start counter animation after card appears
                setTimeout(updateCounter, 300);
            });
            
            // Add click ripple effect
            document.querySelectorAll('.dashboard-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    const ripple = document.createElement('div');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        border-radius: 50%;
                        background: rgba(255,255,255,0.5);
                        left: ${x}px;
                        top: ${y}px;
                        pointer-events: none;
                        animation: ripple 0.6s ease-out;
                    `;
                    
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
            
            // Add ripple animation keyframes dynamically
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
@stop