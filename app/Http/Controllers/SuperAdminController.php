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
    public function statistiques(){

        $nb_boutiques = Boutique::count();
        $chiffreA = Paiement::whereYear('created_at' , now()->year)->sum('montant');
        $chiffreM = Paiement::whereMonth('created_at' , now()->month)->sum('montant');
        $abonnement = Package::get();
        $nb_abonnements = $abonnement->count();
        $abonnements_actifs = Paiement::whereIn('package_id' , $abonnement->pluck('id'))->whereMonth('created_at' , now()->month)->where('statut','valide')->count('package_id');
        $paiements_par_mois = Paiement::selectRaw('MONTH(created_at) as mois, SUM(montant) as total')->where('statut', 'valide')->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $paiements_par_mois[$i] ?? 0;
        }

        $abonnements_par_mois = Paiement::selectRaw('MONTH(created_at) as mois, COUNT(*) as total_abonnements')
        ->where('statut', 'valide')
        ->groupBy('mois')
        ->orderBy('mois')
        ->pluck('total_abonnements', 'mois');

        $abonnements = [];
        for ($i = 1; $i <= 12; $i++) {
            $abonnements[] = $abonnements_par_mois[$i] ?? 0;
        }

        $boutiques = Boutique::with('createur')->withSum(['ventes as total_ventes' => function($query) {$query->whereIn('type_operation', ['vente', 'commande'])->where('status', 1);}], 'montant_total')->get();


        return view('SuperAdmin.statistiques' , compact('nb_boutiques' , 'chiffreA' , 'chiffreM' , 'nb_abonnements' , 'abonnements_actifs', 'data', 'abonnements', 'boutiques'));
    }
}
