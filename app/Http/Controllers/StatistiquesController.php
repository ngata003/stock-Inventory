<?php

namespace App\Http\Controllers;

use App\Models\Coursier;
use App\Models\User;
use App\Models\Vente;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class StatistiquesController extends Controller
{
    //

     public function statistiques_admin(){

        $fk_boutique = session('boutique_active_id');

        $nb_coursiers = Coursier::where('fk_boutique' , $fk_boutique)->count();
        $nb_employes = User::where('fk_boutique' , $fk_boutique)->where('fk_createur' , Auth::user()->id)->count();
        $chffreA = Vente::whereIn('type_operation' , ['commande' , 'vente'])->where('fk_boutique' , $fk_boutique)->whereYear('created_at' , now()->year)->where('status' , 1)->sum('montant_total');
        $nb_ventes = Vente::where('fk_boutique' , $fk_boutique)->where('type_operation' , 'vente')->where('status' , 1)->whereYear('created_at' , now()->year)->count();
        $nb_commandes_val = Vente::where('fk_boutique' , $fk_boutique)->where('type_operation' , 'commande')->whereYear('created_at' , now()->year)->where('status' , 1)->count();
        $nb_commandes_inval = Vente::where('fk_boutique' , $fk_boutique)->where('type_operation' , 'commande')->whereYear('created_at' , now()->year)->where('status' , 0)->count();
        $ventes_par_mois = Vente::selectRaw('MONTH(created_at) as mois, SUM(montant_total) as total')->where('type_operation' , 'vente')->where('status', 1)->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $ventes_par_mois[$i] ?? 0;
        }

        $commandes_par_mois = Vente::selectRaw('MONTH(created_at) as mois, SUM(montant_total) as total')->where('status', 1)->where('type_operation' , 'commande')->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');
        $donnees = [];
        for ($i = 1; $i <= 12; $i++) {
            $donnees[] = $commandes_par_mois[$i] ?? 0;
        }

    $top_clients = Vente::select('nom_client', 'contact_client' ,'email_client', DB::raw('SUM(montant_total) as montant_total'))
        ->where('fk_boutique', $fk_boutique)
        ->whereYear('created_at', now()->year)
        ->whereIn('type_operation', ['commande', 'vente'])
        ->groupBy('nom_client', 'contact_client','email_client')
        ->orderByDesc('montant_total')
        ->take(5)
        ->get();



        return view('Admin.statistiques' , compact('nb_coursiers' ,
        'nb_employes' , 'chffreA' ,'top_clients',
         'nb_ventes' , 'nb_commandes_val' , 'nb_commandes_inval' , 'data' , 'donnees'));
    }


    public function statistiques_boutiques($id){

        $nb_commandes = Vente::where('fk_boutique' , $id)->where('type_operation' , 'commande')->count();
        $nb_ventes = Vente::where('fk_boutique' , $id)->where('type_operation', 'vente')->count();
        $nb_commandes_validees = Vente::where('fk_boutique' , $id)->where('type_operation', 'commande')->where('status' ,1)->count();
        $chiffreA = Vente::whereIn('type_operation' , ['commande' , 'vente'])->where('fk_boutique' , $id)->where('status', 1)->sum('montant_total');
        $ventes_id = Vente::whereIn( 'type_operation', ['commande' , 'vente'])->where('fk_boutique' , $id)->where('status' , 1)->pluck('id');
        $benefice = DB::table('vente_details')->join('produits', 'vente_details.nom_produit', '=', 'produits.nom_produit')->whereIn('fk_vente' ,$ventes_id)->select(DB::raw('SUM(vente_details.qte * produits.benefice) as total_benefice'))->value('total_benefice');
        $top_clients = Vente::where('status', 1)->select(DB::raw("COALESCE(nom_client, contact_client) AS client"),DB::raw("SUM(montant_total) AS total_achats"))
        ->where('fk_boutique', $id)
        ->whereIn('type_operation', ['vente', 'commande'])
        ->groupBy(DB::raw("COALESCE(nom_client, contact_client)"))
        ->orderByDesc('total_achats')
        ->limit(5)
        ->get();

        $labels = $top_clients->pluck('client');
        $montants = $top_clients->pluck('total_achats');

        //recuperer les top produits
        $top_produits = $topProduits = DB::table('vente_details')
        ->select('nom_produit', DB::raw('SUM(montant_total) as total_vendus'))
        ->groupBy('nom_produit')
        ->where('fk_boutique' , $id)
        ->orderByDesc('total_vendus')
        ->limit(5)
        ->get();

        $mois_complets = collect(range(1, 12))->mapWithKeys(function ($mois) {
        $nom = Carbon::create()->month($mois)->translatedFormat('F');
        return [$nom => 0];
        });

        $ventes_par_mois = DB::table('ventes')
            ->selectRaw("MONTH(date_vente) as mois, SUM(montant_total) as total")
            ->where('status', 1)
            ->where('fk_boutique' , $id )
            ->whereIn('type_operation', ['vente','commande'])
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Fusionner les mois avec les totaux réels
        foreach ($ventes_par_mois as $vente) {
            $mois_nom = Carbon::create()->month($vente->mois)->translatedFormat('F');
            $mois_complets[$mois_nom] = $vente->total;
        }

        $labelos = $mois_complets->keys();     // Mois (Janvier, Février, etc.)
        $totaux = $mois_complets->values();   // Montants (0 si pas de ventes)

        return view('SuperAdmin.statistiques_boutiques_admin' , compact('nb_commandes' , 'nb_ventes' , 'nb_commandes_validees' ,
        'chiffreA' , 'labels' , 'montants' , 'benefice', 'top_produits' , 'labelos' , 'totaux' ));
    }



}
