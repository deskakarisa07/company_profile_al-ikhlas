@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Selamat Datang</h3>
        <p class="text-muted mb-0">
            Ringkasan data website dan aktivitas terbaru.
        </p>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-success mb-2">
                        <i class="bi bi-newspaper fs-3"></i>
                    </div>
                    <h6 class="text-muted">Artikel</h6>
                    <h2 class="fw-bold">{{ $counts['articles'] }}</h2>
                    <a href="{{ route('admin.articles.index') }}" class="small text-decoration-none">
                        Kelola →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-primary mb-2">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <h6 class="text-muted">Profil</h6>
                    <h2 class="fw-bold">{{ $counts['profiles'] }}</h2>
                    <a href="{{ route('admin.profiles.index') }}" class="small text-decoration-none">
                        Kelola →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-warning mb-2">
                        <i class="bi bi-mortarboard fs-3"></i>
                    </div>
                    <h6 class="text-muted">Unit Pendidikan</h6>
                    <h2 class="fw-bold">{{ $counts['units'] }}</h2>
                    <a href="{{ route('admin.units.index') }}" class="small text-decoration-none">
                        Kelola →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-info mb-2">
                        <i class="bi bi-images fs-3"></i>
                    </div>
                    <h6 class="text-muted">Galeri</h6>
                    <h2 class="fw-bold">{{ $counts['galleries'] }}</h2>
                    <a href="{{ route('admin.galleries.index') }}" class="small text-decoration-none">
                        Kelola →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-danger mb-2">
                        <i class="bi bi-envelope fs-3"></i>
                    </div>
                    <h6 class="text-muted">Pesan</h6>
                    <h2 class="fw-bold">{{ $counts['messages'] }}</h2>
                    <a href="{{ route('admin.messages.index') }}" class="small text-decoration-none">
                        Kelola →
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm bg-success text-white h-100">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-bell-fill fs-3"></i>
                    </div>
                    <h6>Belum Dibaca</h6>
                    <h2 class="fw-bold">{{ $counts['unread'] }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pesan Terbaru</h5>

                @if ($counts['unread'] > 0)
                    <span class="badge bg-danger">
                        {{ $counts['unread'] }} Belum Dibaca
                    </span>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pengirim</th>
                        <th>Subjek</th>
                        <th>Tanggal</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentMessages as $message)
                        <tr class="{{ !$message->read_at ? 'table-warning' : '' }}">
                            <td>
                                <strong>{{ $message->name }}</strong>
                            </td>

                            <td>
                                {{ $message->subject }}

                                @if (!$message->read_at)
                                    <span class="badge bg-danger ms-2">
                                        Baru
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $message->created_at->format('d M Y H:i') }}
                            </td>

                            <td>
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-success btn-sm">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada pesan masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
