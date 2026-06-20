@extends('layouts.admin')
@section('title', 'Detail Unit')
@section('page-title', 'Detail Unit Pendidikan')
@section('content')
    <div class="card p-4">
        @if ($unit->image_url)
            <img src="{{ $unit->image_url }}" style="max-width:500px;max-height:300px;object-fit:cover" class="rounded mb-3">
        @endif
        <h2>{{ $unit->name }}</h2>
        <p class="lead">{{ $unit->short_description }}</p>
        <p style="white-space:pre-line">{{ $unit->description }}</p>
        <div class="mt-4"><a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-warning">Edit</a> <a
                href="{{ route('admin.units.index') }}" class="btn btn-secondary">Kembali</a></div>
    </div>
@endsection
