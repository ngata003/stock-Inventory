<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();

        if ($user->usertype == 'admin') {
            if (!$user->abonnement_valide || now()->gt($user->date_expiration)) {
                return redirect()->route('paiement.page');
            }
        }

        if ($user->usertype == 'employe') {
            $admin = User::find($user->fk_createur); // ou relation ->admin
            if (!$admin || !$admin->abonnement_valide || now()->gt($admin->date_expiration)) {
                return response(view('oups_paiement'));
            }
        }
        return $next($request);
    }
}
