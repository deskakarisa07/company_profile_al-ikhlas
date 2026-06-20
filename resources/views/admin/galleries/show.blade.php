@extends('layouts.admin')
@section('title','Detail Galeri')
@section('page-title','Detail Galeri')
@section('content')
<div class="card p-4"><img src="{{ $gallery->image_url }}" class="rounded mb-3" style="max-width:650px;max-height:420px;object-fit:cover"><h2>{{ $gallery->title }}</h2><p class="text-muted">{{ $gallery->event_date?->translatedFormat('d F Y') }}</p><p>{{ $gallery->description }}</p><a class="btn btn-warning" href="{{ route('admin.galleries.edit',$gallery) }}">Edit</a> <a class="btn btn-secondary" href="{{ route('admin.galleries.index') }}">Kembali</a></div>
@endsection
