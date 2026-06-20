<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;

class AboutController extends Controller
{
    public function index()
    {
        $company = CompanyProfile::active();

        return view('pages.about', compact('company'));
    }
}
