<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'category',
        'status',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        $image = trim($this->image);

        return str_starts_with($image, 'blogs/')
            ? Storage::url($image)
            : asset('images/blog/'.$image);
    }
}
