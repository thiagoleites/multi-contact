<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Checks if the user is authenticated.
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to aceess this feature.');
        }

        // If the user is authenticated, allow the request to proceed.
        return $next($request);
    }
}
