<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next, ...$guards)
    {
        if (auth()->check()) {
            return $next($request);
        }

        // Rediriger vers la route 'login' si l'utilisateur n'est pas authentifié
        throw new AuthenticationException('Unauthenticated.', $guards);
    }
}

