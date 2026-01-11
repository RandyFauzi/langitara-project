<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'order_id',
        'transaction_id',
        'status',
        'amount',
        'payment_type',
        'paid_at',
        'expiry_date',
        'midtrans_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'expiry_date' => 'date',
        'midtrans_response' => 'array',
    ];

    /**
     * Get the user that owns this package subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the package details.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Check if the subscription is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
            ($this->expiry_date === null || $this->expiry_date->isFuture());
    }

    /**
     * Activate the subscription.
     */
    public function activate(): void
    {
        $durationDays = $this->package->duration_days ?? 0;

        $this->update([
            'status' => 'active',
            'paid_at' => now(),
            'expiry_date' => $durationDays > 0 ? now()->addDays($durationDays) : null,
        ]);
    }

    /**
     * Scope for active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', now());
            });
    }
}
