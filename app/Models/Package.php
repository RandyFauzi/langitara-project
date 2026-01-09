<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'duration_days',
        'max_invitations',
        'max_guests',
        'features',
        'can_publish',
        'is_featured',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'can_publish' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Check if package has promo (original price is higher than current price)
     */
    public function hasPromo(): bool
    {
        return $this->original_price && $this->original_price > $this->price;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->price == 0) {
            return 'Gratis';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted original price
     */
    public function getFormattedOriginalPriceAttribute(): string
    {
        if (!$this->original_price) {
            return '';
        }
        return 'Rp ' . number_format($this->original_price, 0, ',', '.');
    }

    /**
     * Scope for active packages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for featured packages
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
