<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles Comma-separated list of roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $allowedRoles = explode(',', $roles);
        $userRole = session('user_role');

        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->route('medical.index')->withErrors(['error' => 'Unauthorized access.']);
        }

        return $next($request);
    }
}
