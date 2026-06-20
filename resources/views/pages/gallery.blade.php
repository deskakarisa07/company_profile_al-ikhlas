@extends('layouts.app')
@section('title','Galeri')
@section('content')
<style>.gallery-header{background:var(--primary);padding:90px 0}.gallery-card{border:0;border-radius:18px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,.08);transition:.3s}.gallery-card:hover{transform:translateY(-7px)}.gallery-card img{width:100%;height:240px;object-fit:cover}</style>
<section class="gallery-header text-white text-center"><div class="container"><h1 class="fw-bold">Galeri Kegiatan</h1><p class="opacity-75">Dokumentasi kegiatan Yayasan Al Ikhlas</p></div></section>
<section><div class="container"><div class="row g-4">@forelse($galleries as $gallery)<div class="col-md-6 col-lg-4"><div class="card gallery-card h-100"><img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"><div class="card-body"><h5 class="fw-bold">{{ $gallery->title }}</h5>@if($gallery->event_date)<small class="text-success">{{ $gallery->event_date->translatedFormat('d F Y') }}</small>@endif<p class="text-muted mt-2 mb-0">{{ $gallery->description }}</p></div></div></div>@empty<div class="col-12 text-center text-muted py-5"><h5>Belum ada foto galeri.</h5></div>@endforelse</div><div class="d-flex justify-content-center mt-5">{{ $galleries->links('pagination::bootstrap-5') }}</div></div></section>
@endsection
