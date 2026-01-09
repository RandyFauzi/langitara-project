<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check user role
        // Assumption: User model has a 'role' string column or similar method.
        // Adjust logic if Role/Permission package is used (e.g. Spatie) but based on previous context, likely simple string.
        if ($user->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
