<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        $user = Auth::user(); // récupère l'utilisateur connecté

        // Convertir la chaîne "admin,employe" en tableau ['admin','employe']
        $rolesArray = is_array($roles) ? $roles : explode(',', $roles);

        if (!$user || !in_array($user->role, $rolesArray)) {
            abort(403, 'Accès interdit');
        }

        return $next($request);
    }

}
