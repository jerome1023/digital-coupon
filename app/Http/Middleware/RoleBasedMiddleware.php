<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $page): Response
    {
        $authenticatedRole = Role::findOrFail($request->user()->role_id);

        if (($page === 'owner' || $page === 'store') && $authenticatedRole->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($page === 'coupon' && $authenticatedRole->name !== 'store_owner') {
            abort(403, 'Unauthorized action.');
        }

        if ($page === 'my_coupon' && $authenticatedRole->name !== 'customer') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
