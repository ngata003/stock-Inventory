<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Auth;
use Illuminate\Http\Request;

class CommandesController extends Controller
{
    //

    public function liste_commandes(){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');

        if($user->type === "admin"){
            $commandes = Vente::where('fk_boutique' , $fk_boutique)->where('type_operation','commande')->orderBy('created_at', 'desc')->get();
            return view('Users.ventes.liste_commandes' , compact('commandes'));
        }
        elseif ($user->type === "employe") {
            $commandes = Vente::where('fk_boutique' , $fk_boutique)->where('fk_createur' , $user->id)->where('type_operation','commande')->orderBy('created_at', 'desc')->get();
            return view('Users.ventes.liste_commandes' , compact('commandes'));
        }
    }

    public function valid_commandes($id){
        $commande = Vente::where('type_operation' , 'commande')->find($id);
        $commande->status = true;
        $commande->save();

        return back()->with('valid_success' , 'commande validée avec succès');
    }
}
