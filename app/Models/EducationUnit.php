<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EducationUnit extends Model
{
    protected $fillable = ['name', 'short_description', 'description', 'image', 'status', 'sort_order'];

    protected $casts = ['sort_order' => 'integer'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, 'education-units/')
            ? Storage::url($this->image)
            : asset('images/'.$this->image);
    }
}
