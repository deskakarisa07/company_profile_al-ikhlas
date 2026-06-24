@extends('layouts.admin')
@section('title', 'Artikel')
@section('page-title', 'Kelola Artikel/Berita')
@section('content')
    <div class="d-flex gap-2 justify-content-end mb-3">
        <a href="{{ route('admin.articles.export-pdf') }}" class="btn btn-danger">Export PDF</a><a
            href="{{ route('admin.articles.create') }}" class="btn btn-success">Tambah Artikel</a>
    </div>
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td>
                                @if ($article->image_url)
                                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 4px;">
                                @endif
                            </td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->category }}</td>
                            <td><span
                                    class="badge bg-{{ $article->status === 'published' ? 'success' : 'secondary' }}">{{ ucfirst($article->status) }}</span>
                            </td>
                            <td>{{ $article->created_at->format('d M Y') }}</td>
                            <td class="text-nowrap"><a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.articles.show', $article) }}">Detail</a> <a
                                    class="btn btn-sm btn-outline-warning"
                                    href="{{ route('admin.articles.edit', $article) }}">Edit</a>
                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.articles.destroy', $article) }}"
                                    onsubmit="return confirm('Hapus artikel ini?')">@csrf @method('DELETE')<button
                                        class="btn btn-sm btn-outline-danger">Hapus</button></form>
                            </td>
                        </tr>
                    @empty<tr>
                            <td colspan="6" class="text-center">Belum ada artikel.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>{{ $articles->links('pagination::bootstrap-5') }}
    </div>
@endsection
