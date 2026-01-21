<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationMusic extends Model
{
    use HasFactory;

    protected $table = 'invitation_music';

    protected $fillable = [
        'invitation_id',
        'provider',
        'url',
        'embed_url',
        'title',
        'is_valid',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
