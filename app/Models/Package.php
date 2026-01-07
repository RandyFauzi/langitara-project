<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'max_invitations',
        'max_guests',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
