<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\CompanyProfile;
use App\Models\ContactMessage;
use App\Models\EducationUnit;
use App\Models\Gallery;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'articles' => Blog::count(),
            'profiles' => CompanyProfile::count(),
            'units' => EducationUnit::count(),
            'galleries' => Gallery::count(),
            'messages' => ContactMessage::count(),
            'unread' => ContactMessage::whereNull('read_at')->count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('counts', 'recentMessages'));
    }
}
