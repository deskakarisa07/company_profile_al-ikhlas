@extends('layouts.app')
@section('title', 'Profile')

@section('content')

    <style>
        section {
            padding: 90px 0;
        }

        .header-section {
            position: relative;
            overflow: hidden;
            background: var(--primary);
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(100px);
            animation: float 6s ease-in-out infinite;
        }

        .header-section::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 280px;
            height: 280px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            filter: blur(100px);
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .fade-left {
            opacity: 0;
            transform: translateX(-60px);
            transition: all 0.8s ease;
        }

        .fade-right {
            opacity: 0;
            transform: translateX(60px);
            transition: all 0.8s ease;
        }

        .fade-left.show,
        .fade-right.show {
            opacity: 1;
            transform: translateX(0);
        }

        .img-modern {
            border-radius: 20px;
            transition: all 0.4s ease;
        }

        .img-modern:hover {
            transform: scale(1.05) rotate(1deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .card-section {
            transition: all 0.4s ease;
        }

        .card-section:hover {
            transform: translateY(-8px);
        }
    </style>

    <section class="header-section text-white text-center">
        <div class="container">
            <h1 class="fw-bold">Profil Unit Pendidikan</h1>
            <p class="mt-2 opacity-75">Program pendidikan Yayasan Al Ikhlas</p>
        </div>
    </section>

    <section>
        <div class="container">

            @forelse($units as $unit)
                <div class="mb-5 card-section">
                    <div class="row align-items-center g-5 {{ $loop->even ? 'flex-md-row-reverse' : '' }}">
                        <div class="col-md-5 text-center {{ $loop->even ? 'fade-right' : 'fade-left' }}">
                            @if ($unit->image_url)
                                <img src="{{ $unit->image_url }}" class="img-fluid img-modern" style="max-height:320px;"
                                    alt="{{ $unit->name }}">
                            @endif
                        </div>
                        <div class="col-md-7 {{ $loop->even ? 'fade-left' : 'fade-right' }}">
                            <h3 class="fw-bold text-success">{{ $unit->name }}</h3>
                            <p class="text-muted mt-3">{{ $unit->short_description }}</p>
                            <p class="text-muted" style="white-space:pre-line">{{ $unit->description }}</p>
                        </div>
                    </div>
                </div>
            @empty<div class="text-center text-muted">Belum ada data unit pendidikan.</div>
            @endforelse

        </div>
    </section>

    <script>
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        });

        document.querySelectorAll('.fade-left, .fade-right').forEach(el => observer.observe(el));
    </script>

@endsection
