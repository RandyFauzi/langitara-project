<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id', // Nullable if global
        'type', // image, audio, icon, font
        'path',
        'source', // internal, upload, vendor
        'license_type', // free, paid, attribution
        'license_notes',
        'allowed_usage', // template-only, global
        'uploader_id',
        'status',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
