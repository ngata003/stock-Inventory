<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Coursier;
use App\Models\Fournisseur;
use App\Models\Package;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    //

    public function liste_paiements(){

        $paiements = Paiement::orderBy('created_at' , 'desc')->get();
        return view('SuperAdmin.paiements' , compact('paiements'));
    }

    public function liste_boutiques(){
        $inf_boutiques = Boutique::all();
        return view('SuperAdmin.all_boutiques', compact('inf_boutiques'));
    }

    public function liste_utilisateurs(){
        $utilisateurs = User::where('role', 'admin')->where('type','admin')->get();
        return view('SuperAdmin.liste_utilisateurs', compact('utilisateurs'));
    }

    public function details_admin($id){

        $boutiques_admin = Boutique::where('fk_createur' , $id)->get();
        $nb_boutiques = $boutiques_admin->count();
        $nb_coursiers = Coursier::whereIn('fk_boutique', $boutiques_admin->pluck('id'))->count();
        $nb_employes = User::whereIn('fk_boutique', $boutiques_admin->pluck('id'))->count();
        $nb_fournisseurs = Fournisseur::whereIn('fk_boutique', $boutiques_admin->pluck('id'))->count();
        $package = Package::where('fk_createur' , $id)->first();

        return view('SuperAdmin.details_utilisateurs', compact('boutiques_admin', 'nb_boutiques', 'nb_coursiers', 'nb_employes', 'nb_fournisseurs', 'package'));
    }
}
