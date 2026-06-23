<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyProfile extends Model
{
    protected $fillable = [
        'name', 'summary', 'description', 'vision', 'mission', 'logo',
        'address', 'phone', 'email', 'map_url', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo) {
            return asset('images/logo.png');
        }

        return str_starts_with($this->logo, 'profiles/')
            ? Storage::disk('public')->url($this->logo)
            : asset('images/'.$this->logo);
    }

    public static function active(): ?self
    {
        return static::query()->where('is_active', true)->first();
    }
}
