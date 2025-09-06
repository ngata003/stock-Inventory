<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Client;
use App\Models\Coursier;
use App\Models\Fournisseur;
use App\Models\Package;
use App\Models\Paiement;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    //

    public function liste_paiements(Request $request , $mois = null){

        $mois = $request->mois ?? $mois ;

        $search = $request->abonnement ;
        $query = Paiement::orderBy('created_at' , 'desc')
                ->whereYear('created_at' ,now()->year)
                ->when($mois, function ($query, $mois) {
                    return $query->whereMonth('created_at', $mois);
                });

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('nom_depositaire', 'LIKE', "%{$search}%");
            });
        }

        $paiements = $query->paginate(6);

          if ($request->ajax()) {
            return response()->json([
                'html' => view('SuperAdmin.paiements', compact('paiements' ))->render(),
            ]);
        }

        return view('SuperAdmin.paiements' , compact('paiements'));
    }

    public function liste_boutiques(){
        $inf_boutiques = Boutique::all();
        return view('SuperAdmin.all_boutiques', compact('inf_boutiques'));
    }

    public function liste_utilisateurs(Request $request , $mois = null){

        $search = $request->admin ;
        $query = User::where('role', 'admin')->where('type','admin');

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $utilisateurs = $query->paginate(6);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('SuperAdmin.liste_utilisateurs', compact('utilisateurs'))->render(),
            ]);
        }
        return view('SuperAdmin.liste_utilisateurs', compact('utilisateurs'));
    }

    public function details_admin($id){

        $boutiques_admin = Boutique::where('fk_createur' , $id)->get();
        $nb_boutiques = $boutiques_admin->count();
        $nb_coursiers = Coursier::whereIn('fk_boutique', $boutiques_admin->pluck('id'))->count();
        $nb_employes = User::whereIn('fk_boutique', $boutiques_admin->pluck('id'))->count();
        $nb_fournisseurs = Fournisseur::whereIn('fk_boutique', $boutiques_admin->pluck('id'))->count();
        $nb_clients = Client::whereIn('fk_boutique' , $boutiques_admin->pluck('id'))->count();
        $nb_fournisseurs = Fournisseur::whereIn('fk_boutique' , $boutiques_admin->pluck('id'))->count();

        return view('SuperAdmin.details_utilisateurs', compact('boutiques_admin', 'nb_boutiques', 'nb_coursiers',
        'nb_employes', 'nb_fournisseurs' , 'nb_clients' , 'nb_fournisseurs'));
    }
    public function statistiques(Request $request , $mois= null ){

        $mois = $request->mois ?? $mois ;
        $nb_boutiques = Boutique::when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })->count();

        $chiffreA = Paiement::whereYear('created_at' , now()->year)
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })->sum('montant');

        $chiffreM = Paiement::when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        }, function ($query) {
            return $query->whereMonth('created_at', now()->month);
        })->sum('montant');

        $abonnement = Package::whereYear('created_at',now()->year);
        $nb_abonnements = $abonnement
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })->count();

        $abonnements_actifs = Paiement::where('statut','valide')->whereIn('package_id' , $abonnement->pluck('id'))->when($mois , function($query , $mois){
            return  $query->whereMonth('created_at', $mois);
        } , function($query){
            return $query->whereMonth('created_at', now()->month);
        })->count('package_id');

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

        $boutiques = Boutique::with('createur')
        ->withSum(['ventes as total_ventes' => function($query) {$query->whereIn('type_operation', ['vente', 'commande'])
        ->where('status', 1);}], 'montant_total')
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })
        ->get();


        return view('SuperAdmin.statistiques' , compact('nb_boutiques' , 'chiffreA' , 'chiffreM' , 'nb_abonnements' , 'abonnements_actifs', 'data', 'abonnements', 'boutiques'));
    }

    public function paiementsPdf(){

        $annee = now()->year;

        $paiementsParMois = Paiement::selectRaw('MONTH(created_at) as mois, SUM(montant) as total')
            ->where('statut', 'valide')
            ->whereYear('created_at', now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Passer les données à la vue PDF
        $pdf = Pdf::loadView('SuperAdmin.paiement_pdf', [
            'paiementsParMois' => $paiementsParMois,
            'annee' => now()->year
        ]);

        return $pdf->stream('abonnements_'.$annee.'.pdf');
    }
}
