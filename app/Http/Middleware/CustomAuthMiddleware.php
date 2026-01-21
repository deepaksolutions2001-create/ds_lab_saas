<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->withErrors(['error' => 'Please login to access the system.']);
        }

        // Session Recovery: If lab_id is lost but user_id exists, restore the context
        if (!Session::has('lab_id')) {
            $user = \App\Models\User::find(Session::get('user_id'));
            if ($user && $user->role !== 'super_admin' && $user->lab_id) {
                Session::put('lab_id', $user->lab_id);
                Session::put('lab_name', $user->lab?->name);
                
                $fy = \App\Models\FinancialYear::where('lab_id', $user->lab_id)->where('is_active', true)->first();
                if ($fy) Session::put('financial_year_id', $fy->id);
            } elseif ($user && $user->role === 'super_admin') {
                // For Super Admin, fallback to first lab for development convenience
                $lab = \App\Models\Lab::first();
                if ($lab) {
                    Session::put('lab_id', $lab->id);
                    Session::put('lab_name', $lab->name);
                    $fy = \App\Models\FinancialYear::where('lab_id', $lab->id)->where('is_active', true)->first();
                    if ($fy) Session::put('financial_year_id', $fy->id);
                }
            }
        }

        return $next($request);
    }
}
