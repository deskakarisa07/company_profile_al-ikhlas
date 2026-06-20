@extends('layouts.admin')
@section('title','Detail Pesan')
@section('page-title','Detail Pesan')
@section('content')
<div class="card p-4"><div class="row mb-3"><div class="col-md-6"><strong>Nama</strong><div>{{ $message->name }}</div></div><div class="col-md-6"><strong>Email</strong><div><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></div></div></div><strong>Subjek</strong><h4>{{ $message->subject }}</h4><hr><div style="white-space:pre-line">{{ $message->message }}</div><div class="text-muted small mt-4">Dikirim {{ $message->created_at->translatedFormat('d F Y H:i') }}</div><div class="mt-4"><a class="btn btn-success" href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}">Balas via Email</a> <a class="btn btn-secondary" href="{{ route('admin.messages.index') }}">Kembali</a></div></div>
@endsection
