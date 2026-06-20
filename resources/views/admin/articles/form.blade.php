@extends('layouts.admin')
@section('title',$article->exists?'Edit Artikel':'Tambah Artikel')
@section('page-title',$article->exists?'Edit Artikel':'Tambah Artikel')
@section('content')
<div class="card p-4"><form method="POST" enctype="multipart/form-data" action="{{ $article->exists?route('admin.articles.update',$article):route('admin.articles.store') }}">@csrf @if($article->exists)@method('PUT')@endif
<div class="row g-3"><div class="col-md-8"><label class="form-label">Judul</label><input class="form-control" name="title" value="{{ old('title',$article->title) }}" required></div><div class="col-md-4"><label class="form-label">Kategori</label><input class="form-control" name="category" value="{{ old('category',$article->category) }}" required></div>
<div class="col-12"><label class="form-label">Isi Artikel</label><textarea class="form-control" rows="8" name="description" required>{{ old('description',$article->description) }}</textarea></div>
<div class="col-md-6"><label class="form-label">Gambar {{ $article->exists?'(kosongkan jika tidak diganti)':'' }}</label><input class="form-control" type="file" name="image" accept="image/*" {{ $article->exists?'':'required' }}>@if($article->image_url)<img src="{{ $article->image_url }}" class="mt-2 rounded" style="max-height:120px">@endif</div>
<div class="col-md-6"><label class="form-label">Status</label><select class="form-select" name="status"><option value="published" @selected(old('status',$article->status)==='published')>Published</option><option value="draft" @selected(old('status',$article->status)==='draft')>Draft</option></select></div></div>
<div class="mt-4"><button class="btn btn-success">Simpan</button> <a class="btn btn-secondary" href="{{ route('admin.articles.index') }}">Batal</a></div></form></div>
@endsection
