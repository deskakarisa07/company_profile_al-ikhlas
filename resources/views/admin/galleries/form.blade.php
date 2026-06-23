@extends('layouts.admin')
@section('title', $gallery->exists ? 'Edit Galeri' : 'Tambah Galeri')
@section('page-title', $gallery->exists ? 'Edit Galeri' : 'Tambah Galeri')
@section('content')
    <div class="card p-4">
        <form method="POST" enctype="multipart/form-data"
            action="{{ $gallery->exists ? route('admin.galleries.update', $gallery) : route('admin.galleries.store') }}">
            @csrf
            @if ($gallery->exists)
                @method('PUT')
            @endif
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label">Judul</label><input class="form-control" name="title"
                        value="{{ old('title', $gallery->title) }}" required></div>
                <div class="col-md-4"><label class="form-label">Tanggal Kegiatan</label><input class="form-control"
                        type="date" name="event_date"
                        value="{{ old('event_date', $gallery->event_date?->format('Y-m-d')) }}"></div>
                <div class="col-12"><label class="form-label">Keterangan</label>
                    <textarea class="form-control" rows="4" name="description">{{ old('description', $gallery->description) }}</textarea>
                </div>
                <div class="col-md-4"><label class="form-label">Gambar</label><input class="form-control" type="file"
                        name="image" accept="image/*" {{ $gallery->exists ? '' : 'required' }}></div>
                <div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status">
                        <option value="published" @selected(old('status', $gallery->status) === 'published')>Published</option>
                        <option value="draft" @selected(old('status', $gallery->status) === 'draft')>Draft</option>
                    </select></div>
                <div class="col-md-4"><label class="form-label">Urutan</label><input class="form-control" type="number"
                        min="0" name="sort_order" value="{{ old('sort_order', $gallery->sort_order ?? 0) }}"
                        required></div>
            </div>
            <div class="mt-4"><button class="btn btn-success">Simpan</button> <a class="btn btn-secondary"
                    href="{{ route('admin.galleries.index') }}">Batal</a></div>
        </form>
    </div>
@endsection
