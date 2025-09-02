<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ControleConnexion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Vérifier si c'est un admin ou gestionnaire
            if (in_array($user->type, ['admin', 'gestionnaire','superadmin'])) {
                if ($user) {

                    if($user->type === "admin"){
                        return redirect()->route('statistiques')->with('status', 'Vous êtes déjà connecté. Veuillez vous déconnecter avant toute autre action.');
                    }
                    elseif ($user->type === "employe" && $user->role === "vendeur") {
                        return redirect()->route('ventes')->with('status', 'Vous êtes déjà connecté. Veuillez vous déconnecter avant toute autre action.');
                    }
                    elseif($user->type === "employe" && $user->role === "magasinier"){
                        return redirect()->route('produits')->with('status', 'Vous êtes déjà connecté. Veuillez vous déconnecter avant toute autre action.');
                    }
                }
            }
        }
        return $next($request);
    }
}
