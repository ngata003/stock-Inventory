<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkBoutiqueActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!session()->has('boutique_active_id')) {
            $user = Auth::user();
            if ($user) {
                $user->status_connexion = 0;
                $user->save();
            }
            return redirect()->route('login')->with('error', 'Veuillez sélectionner une boutique.');
        }

        return $next($request);
    }
}
