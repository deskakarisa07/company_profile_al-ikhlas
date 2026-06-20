@extends('layouts.app')
@section('title', 'Contact')

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
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.35s ease;
            background: #fff;
        }

        .card-modern:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #eee;
            transition: all 0.25s ease;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.15);
        }

        .btn-success {
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(25, 135, 84, 0.25);
        }

        iframe {
            transition: all 0.4s ease;
        }

        iframe:hover {
            transform: scale(1.02);
        }
    </style>

    <section class="header-section text-white text-center">
        <div class="container fade-up">
            <h1 class="fw-bold">Hubungi Kami</h1>
            <p class="mt-2 opacity-75">
                Silakan hubungi kami untuk informasi lebih lanjut
            </p>
        </div>
    </section>

    <section>
        <div class="container">

            <div class="row g-5">

                <div class="col-md-6 fade-up">
                    <h4 class="fw-bold text-success">Informasi Kontak</h4>

                    <div class="mt-4">
                        <p class="mb-1 fw-semibold">Alamat</p>
                        <p class="text-muted">{{ $company?->address ?? 'Alamat belum tersedia' }}</p>
                    </div>

                    <div class="mt-3">
                        <p class="mb-1 fw-semibold">Telepon</p>
                        <p class="text-muted">{{ $company?->phone ?? '-' }}</p>
                    </div>

                    <div class="mt-3">
                        <p class="mb-1 fw-semibold">Email</p>
                        <p class="text-muted">{{ $company?->email ?? '-' }}</p>
                    </div>

                    <div class="mt-4">
                        <iframe src="{{ $company?->map_url ?? 'https://www.google.com/maps?q=Tangerang&output=embed' }}" width="100%" height="260"
                            style="border:0; border-radius:14px;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>

                <div class="col-md-6 fade-up">
                    <div class="card card-modern p-4">
                        <h4 class="fw-bold text-success mb-3">Kirim Pesan</h4>

                        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Masukkan nama" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Masukkan email" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subjek</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="Subjek pesan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pesan</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Tulis pesan" required>{{ old('message') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
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
