<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'amount',
        'status',
        'message',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'amount' => 'integer',
    ];

    /**
     * Get the invitation that owns the RSVP.
     */
    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * Scope for visible RSVPs only.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope for RSVPs with messages.
     */
    public function scopeWithMessage($query)
    {
        return $query->whereNotNull('message')->where('message', '!=', '');
    }

    /**
     * Scope for filtering by attendance status.
     */
    public function scopeAttending($query)
    {
        return $query->where('status', 'hadir');
    }

    /**
     * Scope for not attending.
     */
    public function scopeNotAttending($query)
    {
        return $query->where('status', 'tidak_hadir');
    }

    /**
     * Scope for undecided.
     */
    public function scopeUndecided($query)
    {
        return $query->where('status', 'ragu');
    }
}
