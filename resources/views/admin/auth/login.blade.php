<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title><link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <style>body{min-height:100vh;background:linear-gradient(135deg,#1b5e20,#43a047);display:grid;place-items:center}.login-card{width:min(430px,92vw);border:0;border-radius:20px}</style>
</head>
<body>
<div class="card login-card shadow-lg p-4 p-md-5">
    <div class="text-center mb-4"><img src="{{ asset('images/logo.png') }}" width="90" class="rounded-circle"><h3 class="mt-3">Login Administrator</h3><p class="text-muted">Yayasan Al Ikhlas</p></div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    <form method="POST" action="{{ route('admin.login.submit') }}">@csrf
        <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus></div>
        <div class="mb-4"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
        <button class="btn btn-success w-100">Login</button>
    </form>
    <a href="{{ route('home') }}" class="text-center mt-3 small">Kembali ke website</a>
</div>
</body></html>
