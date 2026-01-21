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
        'status',
        'active_sections',

        // Bride & Groom
        'groom_name',
        'groom_nickname',
        'groom_father',
        'groom_mother',
        'groom_photo',
        'bride_name',
        'bride_nickname',
        'bride_father',
        'bride_mother',
        'bride_photo',

        // Assets
        'cover_image',
        'music_path',

        // Quote
        'quote_text',
        'quote_author',

        // Events
        'akad_date',
        'akad_location',
        'akad_address',
        'akad_map_link',
        'akad_map_embed',
        'resepsi_date',
        'resepsi_location',
        'resepsi_address',
        'resepsi_map_link',
        'resepsi_map_embed',

        // JSON Lists
        'love_stories',
        'gallery_photos',
        'bank_accounts',

        // Gift
        'gift_address',
    ];

    protected $casts = [
        'active_sections' => 'array',
        'love_stories' => 'array',
        'gallery_photos' => 'array',
        'bank_accounts' => 'array',
        'akad_date' => 'datetime',
        'resepsi_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
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

    public function music()
    {
        return $this->hasOne(InvitationMusic::class);
    }

    // Removed legacy relationships: detail, events, loveStories, galleries

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    /**
     * Helper to retrieve data from the content JSON safely.
     * Use dot notation, e.g. $invitation->getMeta('couple.groom.name')
     */
    public function getMeta(string $key, $default = null)
    {
        return data_get($this->content, $key, $default);
    }
}
