<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Profile')</title>

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">

    <style>
        :root {
            --primary: #2e7d32;
            --primary-soft: rgba(46, 125, 50, 0.1);
            --text-dark: #333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
            color: var(--text-dark);
        }

        section {
            padding: 90px 0;
        }

        .navbar-custom {
            background: rgba(46, 125, 50, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.4px;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            margin-left: 8px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0%;
            height: 2px;
            background: #fff;
            transition: 0.3s;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link:hover {
            opacity: 0.85;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            transition: all 0.35s ease;
            background: #fff;
        }

        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .footer-custom {
            background: var(--primary);
            position: relative;
            overflow: hidden;
        }

        .footer-custom::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(80px);
        }

        .footer-custom::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            filter: blur(80px);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a href="/" class="navbar-brand d-flex align-items-center gap-2">
                <span>Yayasan Al Ikhlas</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">

                    <li class="nav-item">
                        <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a href="/about" class="nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
                    </li>

                    <li class="nav-item">
                        <a href="/profile" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">Profile</a>
                    </li>

                    <li class="nav-item">
                        <a href="/blog" class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('gallery') }}" class="nav-link {{ request()->is('gallery') ? 'active' : '' }}">Galeri</a>
                    </li>

                    <li class="nav-item">
                        <a href="/contact" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer-custom text-white text-center py-5 mt-4">
        <div class="container position-relative">
            <p class="mb-1 fw-semibold">Yayasan Al Ikhlas</p>
            <small>&copy; 2026 All rights reserved</small>
        </div>
    </footer>

    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
