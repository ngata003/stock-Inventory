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
    /*public function handle(Request $request, Closure $next, $types): Response
    {
        $user = Auth::user(); // récupère l'utilisateur connecté

        // Convertir la chaîne "admin,employe" en tableau ['admin','employe']
        $typesArray = is_array($types) ? $types : explode(',', $types);

        if (!$user || !in_array($user->role, $typesArray)) {
            abort(403, 'Accès interdit');
        }

        return $next($request);
    }*/

     public function handle(Request $request, Closure $next, ...$types)
    {

        if (Auth::check()) {
            $user = Auth::user();

            if (!$user || !in_array($user->type, $types)) {
                abort(403, 'Accès interdit');;
            }

            return $next($request);
        }

        return redirect()->route('login');
    }

}
