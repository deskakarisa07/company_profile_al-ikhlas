<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    public function index()
    {
        return view('admin.galleries.index', ['galleries' => Gallery::orderBy('sort_order')->latest()->paginate(10)]);
    }

    public function create()
    {
        return view('admin.galleries.form', ['gallery' => new Gallery]);
    }

    public function show(Gallery $gallery)
    {
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.form', compact('gallery'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $request->file('image')->store('galleries', 'public');
        Gallery::create($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validated($request, true);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('galleries', 'public');
        }
        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Galeri berhasil dihapus.');
    }

    private function validated(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'], 'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['required', 'integer', 'min:0'],
            'image' => [$updating ? 'nullable' : 'required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], ['required' => ':attribute wajib diisi.', 'date' => 'Tanggal kegiatan tidak valid.', 'integer' => ':attribute harus berupa angka.', 'image' => 'File harus berupa gambar.', 'mimes' => 'Format gambar tidak didukung.', 'max' => ':attribute melebihi batas.']);
    }
}
