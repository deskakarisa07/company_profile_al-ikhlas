@extends('layouts.admin')
@section('title','Profil Yayasan')
@section('page-title','Edit Profil Yayasan')
@section('content')
<div class="card p-4">
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.profiles.update') }}">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nama Yayasan</label>
                <input class="form-control" name="name" value="{{ old('name', $profile->name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Logo</label>
                @if($profile->exists)
                    <div class="mb-2"><img src="{{ $profile->logo_url }}" alt="Logo {{ $profile->name }}" style="width:80px;height:80px;object-fit:contain"></div>
                @endif
                <input class="form-control" type="file" name="logo" accept="image/*">
            </div>
            <div class="col-12">
                <label class="form-label">Ringkasan</label>
                <textarea class="form-control" name="summary" rows="2" required>{{ old('summary', $profile->summary) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" rows="5" required>{{ old('description', $profile->description) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Visi</label>
                <textarea class="form-control" name="vision" rows="5" required>{{ old('vision', $profile->vision) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Misi (satu poin per baris)</label>
                <textarea class="form-control" name="mission" rows="5" required>{{ old('mission', $profile->mission) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Alamat</label>
                <textarea class="form-control" name="address" rows="2" required>{{ old('address', $profile->address) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Telepon</label>
                <input class="form-control" name="phone" value="{{ old('phone', $profile->phone) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email" value="{{ old('email', $profile->email) }}" required>
            </div>
            <div class="col-12">
                <label class="form-label">URL Embed Google Maps</label>
                <input class="form-control" type="url" name="map_url" value="{{ old('map_url', $profile->map_url) }}">
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-success">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
