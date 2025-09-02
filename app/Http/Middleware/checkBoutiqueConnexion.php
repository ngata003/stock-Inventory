<?php

namespace App\Http\Middleware;

use App\Models\Boutique;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkBoutiqueConnexion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $boutique = Boutique::find(session('boutique_active_id'));
        if ($boutique) {
            return redirect()->route('statistiques')->with('status' , 'veuillez d\'abord vous dexonnecter avant de retourner vers la page de boutiques');
        }
        return $next($request);
    }
}
