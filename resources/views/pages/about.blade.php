@extends('layouts.app')
@section('title', 'About')

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

        .img-modern {
            border-radius: 20px;
            transition: all 0.4s ease;
        }

        .img-modern:hover {
            transform: scale(1.05);
        }
    </style>

    <section class="header-section text-white text-center">
        <div class="container fade-up">
            <h1 class="fw-bold">Tentang {{ $company?->name ?? 'Yayasan Al Ikhlas' }}</h1>
            <p class="mt-3 opacity-75">
                {{ $company?->summary ?? 'Membangun generasi islami yang unggul dan berakhlak mulia' }}
            </p>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-md-6 fade-up">
                    <h3 class="fw-bold text-success mb-3">Siapa Kami</h3>

                    <p class="text-muted" style="white-space:pre-line">{{ $company?->description }}</p>
                </div>

                <div class="col-md-6 text-center fade-up">
                    <img src="{{ $company?->logo_url ?? asset('images/logo.png') }}"
                        class="img-fluid img-modern shadow p-3 bg-white" style="max-height:320px;">
                </div>

            </div>
        </div>
    </section>

    <section style="background:#f8f9fa;">
        <div class="container">

            <div class="text-center mb-5 fade-up">
                <h2 class="fw-bold text-success">Visi & Misi</h2>
            </div>

            <div class="row g-4">

                <div class="col-md-6 fade-up">
                    <div class="card card-modern p-4 h-100">
                        <h4 class="fw-bold text-success mb-3">Visi</h4>
                        <p class="text-muted">
                            {{ $company?->vision }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6 fade-up">
                    <div class="card card-modern p-4 h-100">
                        <h4 class="fw-bold text-success mb-3">Misi</h4>
                        <ul class="text-muted ps-3 mb-0">
                            @foreach (preg_split('/\r\n|\r|\n/', $company?->mission ?? '') as $mission)
                                @if (trim($mission))
                                    <li class="mb-2">{{ $mission }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section>
        <div class="container">

            <div class="text-center mb-5 fade-up">
                <h2 class="fw-bold text-success">Struktur Organisasi</h2>
                <p class="text-muted">Tim yang mendukung Yayasan Al Ikhlas</p>
            </div>

            <div class="row justify-content-center g-4">

                @foreach ([['img' => 'ketua.png', 'nama' => 'Nama Ketua', 'jabatan' => 'Ketua Yayasan'], ['img' => 'sekertaris.png', 'nama' => 'Nama Sekretaris', 'jabatan' => 'Sekretaris'], ['img' => 'bendahara.png', 'nama' => 'Nama Bendahara', 'jabatan' => 'Bendahara']] as $item)
                    <div class="col-md-3 col-6 fade-up">
                        <div class="card card-modern text-center p-4 h-100">

                            <img src="{{ asset('images/' . $item['img']) }}" class="rounded-circle mx-auto mb-3"
                                style="width:110px; height:110px; object-fit:cover;">

                            <h6 class="fw-bold mb-1">{{ $item['nama'] }}</h6>
                            <small class="text-muted">{{ $item['jabatan'] }}</small>

                        </div>
                    </div>
                @endforeach

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
