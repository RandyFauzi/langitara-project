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
        'payload',
        'song_id',
    ];

    protected $casts = [
        'event_date' => 'date',
        'expired_at' => 'datetime',
        'payload' => 'array',
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

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function detail()
    {
        return $this->hasOne(InvitationDetail::class);
    }

    public function events()
    {
        return $this->hasMany(InvitationEvent::class)->orderBy('sort_order');
    }

    public function loveStories()
    {
        return $this->hasMany(InvitationLoveStory::class)->orderBy('sort_order');
    }

    public function galleries()
    {
        return $this->hasMany(InvitationGallery::class)->orderBy('sort_order');
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
