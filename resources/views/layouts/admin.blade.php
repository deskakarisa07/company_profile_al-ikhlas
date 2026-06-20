<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - Yayasan Al Ikhlas</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <style>
        body {
            background: #f4f7f5
        }

        .admin-wrap {
            min-height: 100vh;
            align-items: stretch
        }

        .sidebar {
            width: 260px;
            flex: 0 0 260px;
            background: #1f6f3d
        }

        .sidebar a {
            color: #dcecdf;
            text-decoration: none;
            border-radius: 10px;
            padding: .7rem .9rem;
            display: block
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, .16);
            color: #fff
        }

        .content {
            min-width: 0
        }

        .card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05)
        }

        .table img {
            width: 70px;
            height: 52px;
            object-fit: cover;
            border-radius: 8px
        }

        @media(max-width:991px) {
            .admin-wrap {
                display: block !important
            }

            .sidebar {
                width: 100%;
                flex-basis: auto;
                min-height: auto
            }

            .sidebar nav {
                display: flex;
                flex-wrap: wrap
            }
        }
    </style>
</head>

<body>
    <div class="d-flex admin-wrap">
        <aside class="sidebar p-3 text-white">
            <h5 class="px-2 py-3">Admin Al Ikhlas</h5>
            <nav class="d-grid gap-1">
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"
                    href="{{ route('admin.articles.index') }}">Artikel/Berita</a>
                <a class="{{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}"
                    href="{{ route('admin.profiles.index') }}">Profil Yayasan</a>
                <a class="{{ request()->routeIs('admin.units.*') ? 'active' : '' }}"
                    href="{{ route('admin.units.index') }}">Unit Pendidikan</a>
                <a class="{{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}"
                    href="{{ route('admin.galleries.index') }}">Galeri</a>
                <a class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"
                    href="{{ route('admin.messages.index') }}">Pesan Masuk</a>
            </nav>
        </aside>
        <main class="content flex-grow-1">
            <header class="bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
                <div><strong>@yield('page-title', 'Administrator')</strong>
                    <div class="small text-muted">{{ auth()->user()->name }}</div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">@csrf<button
                        class="btn btn-outline-danger btn-sm">Logout</button></form>
            </header>
            <div class="p-4">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger"><strong>Periksa kembali form:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
