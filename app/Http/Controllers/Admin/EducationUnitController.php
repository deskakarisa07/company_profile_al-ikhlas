<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EducationUnitController extends Controller
{
    public function index()
    {
        return view('admin.units.index', ['units' => EducationUnit::orderBy('sort_order')->paginate(10)]);
    }

    public function create()
    {
        return view('admin.units.form', ['unit' => new EducationUnit]);
    }

    public function show(EducationUnit $unit)
    {
        return view('admin.units.show', compact('unit'));
    }

    public function edit(EducationUnit $unit)
    {
        return view('admin.units.form', compact('unit'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('education-units', 'public');
        }
        EducationUnit::create($data);

        return redirect()->route('admin.units.index')->with('success', 'Unit pendidikan berhasil ditambahkan.');
    }

    public function update(Request $request, EducationUnit $unit)
    {
        $data = $this->validated($request, $unit);
        if ($request->hasFile('image')) {
            if ($unit->image && str_starts_with($unit->image, 'education-units/')) {
                Storage::disk('public')->delete($unit->image);
            }
            $data['image'] = $request->file('image')->store('education-units', 'public');
        }
        $unit->update($data);

        return redirect()->route('admin.units.index')->with('success', 'Unit pendidikan berhasil diperbarui.');
    }

    public function destroy(EducationUnit $unit)
    {
        if ($unit->image && str_starts_with($unit->image, 'education-units/')) {
            Storage::disk('public')->delete($unit->image);
        }
        $unit->delete();

        return back()->with('success', 'Unit pendidikan berhasil dihapus.');
    }

    private function validated(Request $request, ?EducationUnit $unit = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('education_units')->ignore($unit)],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['required', 'integer', 'min:0'],
            'image' => [$unit ? 'nullable' : 'required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], ['required' => ':attribute wajib diisi.', 'unique' => ':attribute sudah digunakan.', 'integer' => ':attribute harus berupa angka.', 'min' => ':attribute minimal 0.', 'image' => 'File harus berupa gambar.', 'mimes' => 'Format gambar tidak didukung.', 'max' => ':attribute melebihi batas.']);
    }
}
