<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationLoveStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'year',
        'title',
        'story',
        'image',
        'sort_order',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
