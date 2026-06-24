@extends('layouts.admin')
@section('title', 'Galeri')
@section('page-title', 'Kelola Galeri')
@section('content')
    <div class="text-end mb-3">
        <a class="btn btn-success" href="{{ route('admin.galleries.create') }}">Tambah Galeri</a>
    </div>
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galleries as $gallery)
                        <tr>
                            <td><img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 4px;"></td>
                            <td>{{ $gallery->title }}</td>
                            <td>{{ $gallery->event_date?->format('d M Y') ?? '-' }}</td>
                            <td>{{ $gallery->sort_order }}</td>
                            <td><span
                                    class="badge bg-{{ $gallery->status === 'published' ? 'success' : 'secondary' }}">{{ $gallery->status }}</span>
                            </td>
                            <td class="text-nowrap"><a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.galleries.show', $gallery) }}">Detail</a> <a
                                    class="btn btn-sm btn-outline-warning"
                                    href="{{ route('admin.galleries.edit', $gallery) }}">Edit</a>
                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.galleries.destroy', $gallery) }}"
                                    onsubmit="return confirm('Hapus foto ini?')">@csrf @method('DELETE')<button
                                        class="btn btn-sm btn-outline-danger">Hapus</button></form>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="6" class="text-center">Belum ada galeri.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>{{ $galleries->links('pagination::bootstrap-5') }}
    </div>
@endsection
