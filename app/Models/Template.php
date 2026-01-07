<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'style',
        'folder_name',
        'base_path',
        'preview_image_path',
        'is_premium', // Keep for backward compatibility, or use accessor
        'package_access',
        'supported_features',
        'status',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'supported_features' => 'array',
    ];

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function assets()
    {
        return $this->hasMany(TemplateAsset::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePremium($query)
    {
        return $query->where('package_access', '!=', 'free');
    }
}
