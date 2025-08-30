<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Auth;
use Illuminate\Http\Request;

class CommandesController extends Controller
{
    //

    public function liste_commandes( Request $request , $mois = null){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');

        $search = $request->commande ;
        $mois = $request->mois ?? $mois ; 


        $query = Vente::where('fk_boutique' , $fk_boutique)
        ->where('type_operation','commande')
        ->whereYear('created_at' , now()->year)
        ->orderBy('created_at', 'desc')
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        });


        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('contact_client', 'LIKE', "%{$search}%")
                ->orWhereHas('coursiers', function ($q2) use ($search) {
                    $q2->where('nom_coursier', 'LIKE', "%{$search}%");
                });
            });
        }

        if($user->type === "admin"){
            $commandes = $query->paginate(6);
        }
        elseif ($user->type === "employe") {
            $commandes = $query->where('fk_createur' , $user->id)->paginate(6);
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('Users.ventes.liste_commandes', compact('commandes'))->render(),
            ]);
        }


        return view('Users.ventes.liste_commandes' , compact('commandes'));
    }

    public function valid_commandes($id){
        $commande = Vente::where('type_operation' , 'commande')->find($id);
        $commande->status = true;
        $commande->save();

        return back()->with('valid_success' , 'commande validée avec succès');
    }
}
