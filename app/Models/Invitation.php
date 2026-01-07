<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'package_id',
        'slug',
        'title',
        'event_date',
        'location',
        'status',
        'expired_at',
    ];

    protected $casts = [
        'event_date' => 'date',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function detail()
    {
        return $this->hasOne(InvitationDetail::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function rsvps()
    {
        return $this->hasManyThrough(Rsvp::class, Guest::class);
    }
}
