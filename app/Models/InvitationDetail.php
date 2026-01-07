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
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
