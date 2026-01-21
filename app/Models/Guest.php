<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id',
        'name',
        'phone_number',
        'category',
        'slug',
        'status',
    ];

    protected $casts = [
        'category' => 'string',
        'status' => 'string',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($guest) {
            // Auto-generate unique slug if not provided
            if (empty($guest->slug)) {
                $guest->slug = Str::random(10);
            }
        });
    }

    /**
     * Get the invitation that owns the guest.
     */
    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * Generate the personalized invitation link for this guest.
     * Returns the invitation URL with ?to={name} parameter.
     */
    public function getInvitationLink(): string
    {
        $invitation = $this->invitation;

        if (!$invitation) {
            return '';
        }

        $baseUrl = route('public.invitation.show', $invitation->slug);
        $guestName = urlencode($this->name);

        return "{$baseUrl}?to={$guestName}";
    }

    /**
     * Get the invitation link with guest_id parameter (alternative tracking).
     */
    public function getInvitationLinkById(): string
    {
        $invitation = $this->invitation;

        if (!$invitation) {
            return '';
        }

        $baseUrl = route('public.invitation.show', $invitation->slug);

        return "{$baseUrl}?guest_id={$this->id}";
    }

    /**
     * Scope for filtering by category.
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
