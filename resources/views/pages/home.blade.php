@extends('layouts.app')
@section('title', 'Home')

@section('content')

    <style>
        .hero-section {
            position: relative;
            min-height: 95vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background:
                linear-gradient(to right, rgba(255, 255, 255, 0.96) 45%, rgba(255, 255, 255, 0.1)),
                url('{{ asset('images/hero.png') }}') right center / cover no-repeat;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(25, 135, 84, 0.12);
            border-radius: 50%;
            filter: blur(120px);
            animation: float 6s ease-in-out infinite;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -120px;
            left: -120px;
            width: 350px;
            height: 350px;
            background: rgba(25, 135, 84, 0.1);
            border-radius: 50%;
            filter: blur(100px);
            animation: float 8s ease-in-out infinite;
        }

        .about-img {
            border-radius: 20px;
            transition: all 0.5s ease;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .about-img:hover {
            transform: scale(1.04) rotate(0.5deg);
        }

        .about-badge {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 500;
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

        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease;
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card-modern {
            border: none;
            border-radius: 16px;
            transition: all 0.35s ease;
            background: #fff;
        }

        .card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .poster-img {
            max-width: 280px;
            border-radius: 16px;
            transition: all 0.4s ease;
        }

        .poster-img:hover {
            transform: scale(1.05) rotate(1deg);
        }

        .btn-success {
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.3);
        }

        section {
            padding: 90px 0;
        }

        .edu-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            height: 320px;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .edu-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .edu-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent 60%);
            transition: all 0.4s ease;
        }

        .edu-content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            color: #fff;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .edu-card:hover {
            transform: translateY(-10px) scale(1.02);
        }

        .edu-card:hover .edu-img {
            transform: scale(1.1);
        }

        .edu-card:hover .edu-overlay {
            background: linear-gradient(to top, rgba(25, 135, 84, 0.85), transparent 70%);
        }

        .edu-card:hover .edu-content {
            transform: translateY(0);
        }
    </style>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 fade-up">

                    <div class="mb-3">
                        <img src="{{ $company?->logo_url ?? asset('images/logo.png') }}" height="180" class="d-block">
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-light text-success px-3 py-2">
                            Selamat Datang di
                        </span>
                    </div>

                    <h1 class="fw-bold display-5">
                        {{ strtoupper($company?->name ?? 'YAYASAN AL IKHLAS') }}
                    </h1>

                    <p class="mt-3 text-muted">
                        {{ $company?->summary ?? 'Tempat terbaik untuk membentuk generasi islami yang cerdas, berkarakter, dan berakhlak mulia.' }}
                    </p>

                    <div class="mt-4">
                        <a href="/about" class="btn btn-success px-4 me-2">Kenali Kami</a>
                        <a href="/contact" class="btn btn-outline-success px-4">Hubungi Kami</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-md-6 fade-up">
                    <img src="{{ asset('images/hero-profile.png') }}" class="img-fluid about-img">
                </div>
                <div class="col-md-6 fade-up">
                    <h2 class="fw-bold text-success">Tentang Kami</h2>
                    <p class="mt-3 text-muted">{{ $company?->description }}</p>
                    <div class="mt-4 d-flex gap-3 flex-wrap">
                        <div class="about-badge">
                            🎓 Pendidikan Berkualitas
                        </div>
                        <div class="about-badge">
                            🌿 Lingkungan Islami
                        </div>
                        <div class="about-badge">
                            ⭐ Berkarakter
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section style="background:#f8f9fa;">
        <div class="container">

            <div class="text-center mb-5 fade-up">
                <h2 class="fw-bold text-success">Unit Pendidikan</h2>
                <p class="text-muted">Program pendidikan yang kami sediakan</p>
            </div>

            <div class="row g-4">@forelse($units as $unit)<div class="col-md-4 fade-up"><div class="edu-card">@if($unit->image_url)<img src="{{ $unit->image_url }}" class="edu-img" alt="{{ $unit->name }}">@endif<div class="edu-overlay"></div><div class="edu-content"><h5 class="fw-bold">{{ $unit->name }}</h5><p>{{ $unit->short_description }}</p></div></div></div>@empty<div class="text-center text-muted">Belum ada unit pendidikan.</div>@endforelse</div>

        </div>
    </section>

    <section>
        <div class="container">
            <div class="text-center mb-5 fade-up">
                <h2 class="fw-bold text-success">Keunggulan Kami</h2>
            </div>

            <div class="row text-center g-4">
                <div class="col-md-4 fade-up">
                    <div class="card card-modern p-4 h-100">
                        <h5 class="fw-bold">Guru Berpengalaman</h5>
                        <p class="text-muted">Tenaga pengajar profesional dan kompeten.</p>
                    </div>
                </div>

                <div class="col-md-4 fade-up">
                    <div class="card card-modern p-4 h-100">
                        <h5 class="fw-bold">Lingkungan Islami</h5>
                        <p class="text-muted">Mendukung pembentukan akhlak mulia.</p>
                    </div>
                </div>

                <div class="col-md-4 fade-up">
                    <div class="card card-modern p-4 h-100">
                        <h5 class="fw-bold">Fasilitas Lengkap</h5>
                        <p class="text-muted">Menunjang kegiatan belajar secara optimal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section style="background:#f8f9fa;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-5 text-center fade-up">
                    <img src="{{ asset('images/poster.jpg') }}" class="img-fluid poster-img">
                </div>

                <div class="col-md-7 fade-up">
                    <h3 class="fw-bold text-success">Penerimaan Siswa Baru</h3>
                    <p class="text-muted mt-3">
                        Pendaftaran siswa baru untuk jenjang TK, SD, dan SMP telah dibuka.
                    </p>

                    <ul class="text-muted">
                        <li>Lingkungan islami</li>
                        <li>Guru profesional</li>
                        <li>Fasilitas lengkap</li>
                    </ul>

                    <a href="/contact" class="btn btn-success mt-3 px-4">Daftar Sekarang</a>
                </div>
            </div>
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

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    </script>

@endsection
