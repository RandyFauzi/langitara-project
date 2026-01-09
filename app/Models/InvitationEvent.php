<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'title',
        'date',
        'time_start',
        'time_end',
        'location_name',
        'address',
        'map_url',
        'sort_order',
    ];

    protected $casts = [
        'date' => 'date',
        // time casts are usually string 'H:i:s' in Laravel, or can be cast to custom time objects if needed.
        // For now leaving as default (string) is safer for simple output.
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
