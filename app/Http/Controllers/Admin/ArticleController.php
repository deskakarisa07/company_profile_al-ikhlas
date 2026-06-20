<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CompanyProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Blog::latest()->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.form', ['article' => new Blog]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }
        Blog::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function show(Blog $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Blog $article)
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Blog $article)
    {
        $data = $this->validateData($request, $article);
        if ($request->hasFile('image')) {
            $this->deleteUploadedFile($article->image);
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }
        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Blog $article)
    {
        $this->deleteUploadedFile($article->image);
        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    public function exportPdf()
    {
        $articles = Blog::latest()->get();
        $company = CompanyProfile::active();
        $summary = ['total' => $articles->count(), 'published' => $articles->where('status', 'published')->count(), 'draft' => $articles->where('status', 'draft')->count()];

        return Pdf::loadView('admin.articles.pdf', compact('articles', 'company', 'summary'))
            ->setPaper('a4', 'landscape')
            ->download('laporan-artikel-'.now()->format('Y-m-d').'.pdf');
    }

    private function validateData(Request $request, ?Blog $article = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('blogs', 'title')->ignore($article)],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'image' => [$article ? 'nullable' : 'required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], $this->messages());
    }

    private function messages(): array
    {
        return ['required' => ':attribute wajib diisi.', 'unique' => ':attribute sudah digunakan.', 'image' => 'File harus berupa gambar.', 'mimes' => 'Format gambar harus jpeg, jpg, png, atau webp.', 'max' => 'Ukuran/nilai :attribute melebihi batas.'];
    }

    private function deleteUploadedFile(?string $path): void
    {
        if ($path && str_starts_with($path, 'blogs/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
