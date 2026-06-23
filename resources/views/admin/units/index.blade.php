@extends('layouts.admin')
@section('title', 'Unit Pendidikan')
@section('page-title', 'Kelola Unit Pendidikan')
@section('content')
    <div class="text-end mb-3">
        <a class="btn btn-success" href="{{ route('admin.units.create') }}">Tambah Unit</a>
    </div>
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($units as $unit)
                        <tr>
                            <td>
                                @if ($unit->image_url)
                                    <img src="{{ $unit->image_url }}">
                                @endif
                            </td>
                            <td>{{ $unit->name }}</td>
                            <td>{{ $unit->sort_order }}</td>
                            <td><span
                                    class="badge bg-{{ $unit->status === 'published' ? 'success' : 'secondary' }}">{{ $unit->status }}</span>
                            </td>
                            <td class="text-nowrap"><a class="btn btn-sm btn-outline-primary"
                                    href="{{ route('admin.units.show', $unit) }}">Detail</a> <a
                                    class="btn btn-sm btn-outline-warning"
                                    href="{{ route('admin.units.edit', $unit) }}">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.units.destroy', $unit) }}"
                                    onsubmit="return confirm('Hapus unit ini?')">@csrf @method('DELETE')<button
                                        class="btn btn-sm btn-outline-danger">Hapus</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>{{ $units->links('pagination::bootstrap-5') }}
    </div>
@endsection
