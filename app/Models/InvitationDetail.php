<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'groom_name',
        'bride_name',
        'content',
        'active_sections',
        'meta_settings',
    ];

    protected $casts = [
        'content' => 'array',
        'active_sections' => 'array',
        'meta_settings' => 'array',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
