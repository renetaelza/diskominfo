<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin')->user();
        logger('Admin attempting access: ', ['role' => $user?->role]);

        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
