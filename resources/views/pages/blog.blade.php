@extends('layouts.app')
@section('title', 'Blog')

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

        .blog-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            transition: all 0.35s ease;
        }

        .blog-card:hover {
            transform: translateY(-10px) scale(1.01);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .blog-img-wrapper {
            overflow: hidden;
            height: 100%;
        }

        .blog-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 220px;
            transition: transform 0.5s ease;
        }

        .blog-card:hover .blog-img {
            transform: scale(1.08);
        }

        .badge {
            font-size: 12px;
            padding: 6px 10px;
        }

        .pagination {
            gap: 6px;
        }

        .page-link {
            border-radius: 8px !important;
        }
    </style>

    <section class="header-section text-white text-center">
        <div class="container fade-up">
            <h1 class="fw-bold">Berita & Artikel</h1>
            <p class="mt-2 opacity-75">
                Informasi dan kegiatan terbaru Yayasan Al Ikhlas
            </p>
        </div>
    </section>

    <section>
        <div class="container">

            @forelse ($blogs as $blog)
                <div class="mb-4 fade-up">

                    <a href="{{ route('blog.show', $blog->id) }}" class="text-decoration-none text-dark">

                        <div class="row g-0 align-items-center blog-card">

                            <div class="col-md-4 blog-img-wrapper">
                                @if($blog->image_url)<img src="{{ $blog->image_url }}" class="blog-img" alt="{{ $blog->title }}">@endif
                            </div>

                            <div class="col-md-8">
                                <div class="p-4">

                                    <small class="text-muted">
                                        {{ $blog->created_at->format('d M Y') }}
                                    </small>

                                    <h5 class="fw-bold mt-2">
                                        {{ $blog->title }}
                                    </h5>

                                    <p class="text-muted mb-3">
                                        {{ Str::limit($blog->description, 150) }}
                                    </p>

                                    <span class="badge bg-success">
                                        {{ $blog->category }}
                                    </span>

                                </div>
                            </div>

                        </div>

                    </a>

                </div>
            @empty

                <div class="text-center py-5 fade-up">
                    <h5 class="text-muted">Belum ada artikel</h5>
                </div>
            @endforelse

            <div class="d-flex justify-content-center mt-5 fade-up">
                {{ $blogs->links('pagination::bootstrap-5') }}
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
