@extends('layouts.admin')
@section('title', 'Pesan Masuk')
@section('page-title', 'Pesan Masuk')
@section('content')
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Subjek</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ $message->read_at ? '' : 'fw-bold' }}">
                            <td><span
                                    class="badge bg-{{ $message->read_at ? 'secondary' : 'success' }}">{{ $message->read_at ? 'Dibaca' : 'Baru' }}</span>
                            </td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                            <td class="text-nowrap"><a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.messages.show', $message) }}">Buka</a>
                                @if (!$message->read_at)
                                    <form class="d-inline" method="POST"
                                        action="{{ route('admin.messages.read', $message) }}">@csrf @method('PATCH')<button
                                            class="btn btn-sm btn-outline-success">Tandai dibaca</button></form>
                                @endif
                                <form class="d-inline" method="POST"
                                    action="{{ route('admin.messages.destroy', $message) }}"
                                    onsubmit="return confirm('Hapus pesan?')">@csrf @method('DELETE')<button
                                        class="btn btn-sm btn-outline-danger">Hapus</button></form>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="6" class="text-center">Belum ada pesan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>{{ $messages->links('pagination::bootstrap-5') }}
    </div>
@endsection
