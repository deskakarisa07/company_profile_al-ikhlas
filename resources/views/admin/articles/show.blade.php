@extends('layouts.admin')
@section('title', 'Detail Artikel')
@section('page-title', 'Detail Artikel')
@section('content')
    <div class="card p-4">
        @if ($article->image_url)
            <img src="{{ $article->image_url }}" class="rounded mb-3"
                style="max-width:500px;max-height:300px;object-fit:cover">
        @endif
        <h2>{{ $article->title }}</h2>
        <p><span class="badge bg-success">{{ $article->category }}</span> <span
                class="badge bg-secondary">{{ $article->status }}</span></p>
        <div style="white-space:pre-line">{{ $article->description }}</div>
        <div class="mt-4"><a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning">Edit</a> <a
                href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Kembali</a></div>
    </div>
@endsection
