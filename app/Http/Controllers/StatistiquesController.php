<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class StatistiquesController extends Controller
{
    //

     public function statistiques_admin(){

        $fk_boutique = session('boutique_active_id');

        $nb_commandes = Vente::where('fk_boutique' , $fk_boutique)->where('type_operation' , 'commande')->count();
        $nb_ventes = Vente::where('fk_boutique' , $fk_boutique)->where('type_operation', 'vente')->count();
        $nb_commandes_validees = Vente::where('fk_boutique' , $fk_boutique)->where('type_operation', 'commande')->where('status' ,1)->count();
        $chiffreA = Vente::whereIn('type_operation' , ['commande' , 'vente'])->where('fk_boutique' , $fk_boutique)->where('status', 1)->sum('montant_total');
        $ventes_id = Vente::whereIn( 'type_operation', ['commande' , 'vente'])->where('fk_boutique' , $fk_boutique)->where('status' , 1)->pluck('id');
        $benefice = DB::table('vente_details')->join('produits', 'vente_details.nom_produit', '=', 'produits.nom_produit')->whereIn('fk_vente' ,$ventes_id)->select(DB::raw('SUM(vente_details.qte * produits.benefice) as total_benefice'))->value('total_benefice');
        $top_clients = Vente::where('status', 1)->select(DB::raw("COALESCE(nom_client, contact_client) AS client"),DB::raw("SUM(montant_total) AS total_achats"))
        ->where('fk_boutique', $fk_boutique)
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
        ->where('fk_boutique' , $fk_boutique)
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
            ->where('fk_boutique' , $fk_boutique)
            ->where('type_operation', 'vente')
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

        return view('Admin.statistiques' , compact('nb_commandes' ,
         'nb_ventes' , 'nb_commandes_validees',
        'chiffreA','benefice','labels', 'montants','top_produits','labelos', 'totaux'));
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
            ->where('type_operation', 'vente')
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
