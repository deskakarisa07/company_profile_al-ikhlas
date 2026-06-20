<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $company = CompanyProfile::active();

        return view('pages.contact', compact('company'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'required' => ':attribute wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'max' => ':attribute terlalu panjang.',
        ], [
            'name' => 'Nama', 'email' => 'Email', 'subject' => 'Subjek', 'message' => 'Pesan',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim. Terima kasih telah menghubungi kami.');
    }
}
