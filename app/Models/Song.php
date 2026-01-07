<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'category',
        'file_path',
        'duration',
        'is_premium',
        'min_package_level',
        'status',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    /**
     * Get the full URL for the song file.
     */
    public function getUrlAttribute()
    {
        return asset($this->file_path);
    }
}
