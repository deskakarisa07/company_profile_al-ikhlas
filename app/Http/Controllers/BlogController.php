<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 'published')->latest()->paginate(3);

        return view('pages.blog', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        abort_unless($blog->status === 'published', 404);

        return view('pages.blog-detail', compact('blog'));
    }
}
