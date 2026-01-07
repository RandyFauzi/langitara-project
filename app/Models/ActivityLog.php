<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'actor_type',
        'actor_id',
        'actor_name',
        'action',
        'entity_type',
        'entity_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    /**
     * Helper to create a new log entry.
     */
    public static function log($action, $description = null, $entity = null)
    {
        $actorType = 'system';
        $actorId = 0; // System ID
        $actorName = 'System';

        if (Auth::check()) {
            $user = Auth::user();
            // Determine if admin (checking if user has role or is in admins table logic - simplistic for now based on current context)
            // Assuming we are using the 'admins' table and guard, OR 'users' table. 
            // For now, let's assume standard Laravel Auth. 
            // If there's a specific Admin guard, we should check that.
            // Based on previous files, 'admins' table exists but 'users' table also has roles/status.
            // DashboardController showed Auth::user().

            $actorType = 'user'; // Default
            if (Request::is('admin/*')) {
                $actorType = 'admin';
            }

            $actorId = $user->id;
            $actorName = $user->name;
        }

        $entityType = null;
        $entityId = null;

        if ($entity && $entity instanceof Model) {
            $entityType = class_basename($entity);
            $entityId = $entity->id;
        }

        return self::create([
            'actor_type' => $actorType,
            'actor_id' => $actorId,
            'actor_name' => $actorName,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
