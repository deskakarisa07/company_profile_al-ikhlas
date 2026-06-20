<?php

namespace App\Http\Controllers;

use App\Models\EducationUnit;

class ProfileController extends Controller
{
    public function index()
    {
        $units = EducationUnit::where('status', 'published')->orderBy('sort_order')->get();

        return view('pages.profile', compact('units'));
    }
}
