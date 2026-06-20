<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompanyProfileController extends Controller
{
    public function index()
    {
        return view('admin.profiles.index', ['profile' => $this->profile()]);
    }

    public function update(Request $request)
    {
        $profile = $this->profile();
        $data = $this->validated($request, $profile);

        if ($request->hasFile('logo')) {
            if ($profile->logo && str_starts_with($profile->logo, 'profiles/')) {
                Storage::disk('public')->delete($profile->logo);
            }
            $data['logo'] = $request->file('logo')->store('profiles', 'public');
        }

        $data['is_active'] = true;
        $profile->fill($data)->save();

        return redirect()->route('admin.profiles.index')->with('success', 'Profil berhasil diperbarui.');
    }

    private function validated(Request $request, CompanyProfile $profile): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('company_profiles')->ignore($profile)],
            'summary' => ['required', 'string'], 'description' => ['required', 'string'],
            'vision' => ['required', 'string'], 'mission' => ['required', 'string'],
            'address' => ['required', 'string'], 'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:150'], 'map_url' => ['nullable', 'url', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], ['required' => ':attribute wajib diisi.', 'unique' => ':attribute sudah digunakan.', 'email' => 'Format email tidak valid.', 'url' => 'URL peta tidak valid.', 'image' => 'Logo harus berupa gambar.', 'mimes' => 'Format logo tidak didukung.', 'max' => ':attribute melebihi batas.']);
    }

    private function profile(): CompanyProfile
    {
        return CompanyProfile::active()
            ?? CompanyProfile::query()->oldest('id')->first()
            ?? new CompanyProfile;
    }
}
