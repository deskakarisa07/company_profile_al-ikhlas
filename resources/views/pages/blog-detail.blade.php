@extends('layouts.app')
@section('title', $blog->title)

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
            width: 320px;
            height: 320px;
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

        .blog-img-wrapper {
            overflow: hidden;
            border-radius: 20px;
        }

        .blog-detail-img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .blog-img-wrapper:hover .blog-detail-img {
            transform: scale(1.05);
        }

        .blog-content {
            max-width: 800px;
            line-height: 1.9;
            font-size: 17px;
        }

        .blog-content p {
            margin-bottom: 18px;
        }

        .btn-modern {
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateX(-5px);
            box-shadow: 0 10px 25px rgba(25, 135, 84, 0.2);
        }
    </style>

    <section class="header-section text-white text-center">
        <div class="container fade-up">
            <h1 class="fw-bold">{{ $blog->title }}</h1>
            <p class="mt-2 opacity-75">
                {{ $blog->created_at->format('d M Y') }} • {{ $blog->category }}
            </p>
        </div>
    </section>

    <section>
        <div class="container">

            <div class="mb-5 text-center fade-up">
                <div class="blog-img-wrapper">
                    @if($blog->image_url)<img src="{{ $blog->image_url }}" class="blog-detail-img" alt="{{ $blog->title }}">@endif
                </div>
            </div>

            <div class="blog-content mx-auto fade-up">
                <p class="text-muted">
                    {{ $blog->description }}
                </p>
            </div>

            <div class="mt-5 fade-up">
                <a href="/blog" class="btn btn-outline-success btn-modern px-4">
                    ← Kembali ke Blog
                </a>
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
