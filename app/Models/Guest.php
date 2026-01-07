<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'phone',
        'category',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }
}
