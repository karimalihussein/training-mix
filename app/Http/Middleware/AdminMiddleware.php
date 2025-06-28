<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/dashboard/login');
        }

        // For now, allow all authenticated users to access admin
        // You can add role/permission checks here later
        // if (!Auth::user()->hasRole('admin')) {
        //     abort(403, 'Unauthorized access to admin panel.');
        // }

        return $next($request);
    }
}
