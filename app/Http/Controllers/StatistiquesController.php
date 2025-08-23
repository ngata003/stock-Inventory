<?php

namespace App\Http\Controllers;

use App\Models\Coursier;
use App\Models\User;
use App\Models\Vente;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

class StatistiquesController extends Controller
{
    //

     public function statistiques_admin(Request $request, $mois = null){

        $location = GeoIP::getLocation();
        $country_code = $location->iso_code;

        $currencies = config('currency');
        $currency = $currencies[$country_code] ?? '$';

        $mois = $request->mois ?? $mois;

        $fk_boutique = session('boutique_active_id');
        $nb_coursiers = Coursier::where('fk_boutique' , $fk_boutique)->count();
        $nb_employes = User::where('fk_boutique' , $fk_boutique)->where('fk_createur' , Auth::user()->id)->count();

        $chffreA = Vente::whereIn('type_operation' , ['commande' , 'vente'])
        ->where('fk_boutique' , $fk_boutique)
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })
        ->whereYear('created_at' , now()->year)
        ->where('status' , 1)->sum('montant_total');

        $nb_ventes = Vente::where('fk_boutique' , $fk_boutique)
        ->where('type_operation' , 'vente')
        ->where('status' , 1)
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })
        ->whereYear('created_at' , now()->year)->count();

        $nb_commandes_val = Vente::where('fk_boutique' , $fk_boutique)
        ->where('type_operation' , 'commande')
        ->whereYear('created_at' , now()->year)
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })
        ->where('status' , 1)->count();

        $nb_commandes_inval = Vente::where('fk_boutique' , $fk_boutique)
        ->where('type_operation' , 'commande')
        ->whereYear('created_at' , now()->year)
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })
        ->where('status' , 0)->count();

        $ventes_par_mois = Vente::selectRaw('MONTH(created_at) as mois, SUM(montant_total) as total')->where('fk_boutique' , $fk_boutique)->where('type_operation' , 'vente')->where('status', 1)->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $ventes_par_mois[$i] ?? 0;
        }

        $commandes_par_mois = Vente::selectRaw('MONTH(created_at) as mois, SUM(montant_total) as total')
        ->where('fk_boutique' , $fk_boutique)->where('status', 1)
        ->where('type_operation' , 'commande')->groupBy('mois')
        ->orderBy('mois')->pluck('total', 'mois');
        $donnees = [];
        for ($i = 1; $i <= 12; $i++) {
            $donnees[] = $commandes_par_mois[$i] ?? 0;
        }

        $ventes_id = Vente::where('fk_boutique' , $fk_boutique)
        ->where('status' , 1)
        ->whereYear('created_at', now()->year)->pluck('id');

        $benefice = DB::table('vente_details')
        ->join('produits', function($join) use ($fk_boutique) {
        $join->on('vente_details.nom_produit', '=', 'produits.nom_produit')
        ->where('produits.fk_boutique', '=', $fk_boutique);})
        ->whereIn('fk_vente' ,$ventes_id)
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('vente_details.created_at', $mois);
        })
        ->select(DB::raw('SUM(vente_details.qte * produits.benefice) as total_benefice'))
        ->value('total_benefice');

        $top_clients = Vente::select(
            DB::raw("COALESCE(nom_client, contact_client) as client_identifiant"),
            DB::raw('SUM(montant_total) as total_montant')
        )
        ->where('fk_boutique', $fk_boutique)
        ->where('status', 1)
        ->whereYear('created_at', now()->year)
        ->whereIn('type_operation', ['commande', 'vente'])
        ->groupBy('client_identifiant')
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })
        ->orderByDesc('total_montant')
        ->take(5)
        ->get();

        $top_produits = DB::table('vente_details')
        ->join('ventes', 'ventes.id', '=', 'vente_details.fk_vente')
        ->select(
            'vente_details.nom_produit',
            DB::raw("SUM(vente_details.montant_total) as total_montant")
        )
        ->whereIn('ventes.id', $ventes_id)
        ->where('vente_details.fk_boutique', $fk_boutique)
        ->whereYear('vente_details.created_at', now()->year)
        ->where('ventes.status', 1)
        ->whereIn('ventes.type_operation', ['vente' , 'commande'])
        ->groupBy('vente_details.nom_produit')
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('vente_details.created_at', $mois);
        })
        ->orderByDesc('total_montant')
        ->limit(5)
        ->get();



        return view('Admin.statistiques' , compact('nb_coursiers' ,
        'nb_employes' , 'chffreA' ,'top_clients', 'top_produits', 'benefice',
         'nb_ventes' , 'nb_commandes_val' , 'nb_commandes_inval' , 'data' , 'donnees' , 'currency'));
    }


    public function statistiques_boutiques($id){

        $nb_commandes = Vente::where('fk_boutique' , $id)->where('type_operation' , 'commande')->whereYear('created_at' , now()->year)->count();
        $nb_ventes = Vente::where('fk_boutique' , $id)->where('type_operation', 'vente')->whereYear('created_at' , now()->year)->count();
        $nb_commandes_validees = Vente::where('fk_boutique' , $id)->where('type_operation', 'commande')->where('status' ,1)->whereYear('created_at' , now()->year)->count();
        $chiffreA = Vente::whereIn('type_operation' , ['commande' , 'vente'])->where('fk_boutique' , $id)->where('status', 1)->whereYear('created_at' , now()->year)->sum('montant_total');
        $ventes_id = Vente::whereIn( 'type_operation', ['commande' , 'vente'])->where('fk_boutique' , $id)->where('status' , 1)->whereYear('created_at' , now()->year)->pluck('id');

        $benefice = DB::table('vente_details')
        ->join('produits', function($join) use ($id) {
        $join->on('vente_details.nom_produit', '=', 'produits.nom_produit')
        ->where('produits.fk_boutique', '=', $id);})
        ->whereIn('fk_vente' ,$ventes_id)
        ->select(DB::raw('SUM(vente_details.qte * produits.benefice) as total_benefice'))
        ->value('total_benefice');

        $ventes_id = Vente::where('fk_boutique' , $id)->where('status' , 1)->whereYear('created_at', now()->year)->pluck('id');

        $top_produits = DB::table('vente_details')
        ->join('ventes', 'ventes.id', '=', 'vente_details.fk_vente')
        ->select(
            'vente_details.nom_produit',
            DB::raw("SUM(vente_details.montant_total) as total_montant")
        )
        ->whereIn('ventes.id', $ventes_id)
        ->where('vente_details.fk_boutique', $id)
        ->whereYear('vente_details.created_at', now()->year)
        ->where('ventes.status', 1)
        ->whereIn('ventes.type_operation', ['vente' , 'commande'])
        ->groupBy('vente_details.nom_produit')
        ->orderByDesc('total_montant')
        ->limit(5)
        ->get();

        $top_clients = Vente::select(
            DB::raw("COALESCE(nom_client, contact_client) as client_identifiant"),
            DB::raw('SUM(montant_total) as total_montant')
        )
        ->where('fk_boutique', $id)
        ->where('status', 1)
        ->whereYear('created_at', now()->year)
        ->whereIn('type_operation', ['commande', 'vente'])
        ->groupBy('client_identifiant')
        ->orderByDesc('total_montant')
        ->take(5)
        ->get();

        $ventes_par_mois = Vente::selectRaw('MONTH(created_at) as mois, SUM(montant_total) as total')->where('type_operation' , 'vente')->where('status', 1)->groupBy('mois')->where('fk_boutique' , $id)->orderBy('mois')->pluck('total', 'mois');
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $ventes_par_mois[$i] ?? 0;
        }

        $commandes_par_mois = Vente::selectRaw('MONTH(created_at) as mois, SUM(montant_total) as total')->where('status', 1)->whereYear('created_at' , now()->year)->where('type_operation' , 'commande')->where('fk_boutique' , $id)->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');
        $donnees = [];
        for ($i = 1; $i <= 12; $i++) {
            $donnees[] = $commandes_par_mois[$i] ?? 0;
        }


        return view('SuperAdmin.statistiques_boutiques_admin' ,
        compact('nb_commandes' , 'nb_ventes' ,
        'nb_commandes_validees' , 'data' , 'donnees',
        'chiffreA' , 'benefice', 'top_produits' , 'top_clients'));
    }



}
