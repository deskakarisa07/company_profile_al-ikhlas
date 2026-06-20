<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('status', 'published')
            ->orderBy('sort_order')->latest('event_date')->paginate(9);

        return view('pages.gallery', compact('galleries'));
    }
}
