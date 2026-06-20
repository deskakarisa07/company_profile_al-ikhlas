<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\EducationUnit;
use App\Models\Gallery;

class HomeController extends Controller
{
    public function index()
    {
        $company = CompanyProfile::active();
        $units = EducationUnit::where('status', 'published')->orderBy('sort_order')->get();
        $galleries = Gallery::where('status', 'published')->orderBy('sort_order')->latest('event_date')->take(6)->get();

        return view('pages.home', compact('company', 'units', 'galleries'));
    }
}
