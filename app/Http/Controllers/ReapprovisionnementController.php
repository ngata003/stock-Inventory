<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\Produit;
use App\Models\Reapprovionnement;
use App\Models\Reapprovisionnement;
use App\Models\Suggestion;
use Auth;
use Illuminate\Http\Request;

class ReapprovisionnementController extends Controller
{
    //
    public function approvisionnement(Request $request , $mois = null) {

        $fk_boutique = session('boutique_active_id');
        $user = Auth::user();

        $search = $request->approv ;

        $mois = $request->mois ?? $mois ;

        $produits = Produit::where('fk_boutique' , $fk_boutique)->get();
        $fournisseurs = Fournisseur::where('fk_boutique', $fk_boutique)->get();

        $query = Reapprovisionnement::with(['fournisseur' , 'produit'])
        ->where('fk_boutique' , $fk_boutique)
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        });
;


        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('produit', function ($q2) use ($search) {
                    $q2->where('nom_produit', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('fournisseur', function ($q2) use ($search) {
                    $q2->where('nom_fournisseur', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($user->type === "admin") {
            $approvisionnement = $query->paginate(6);
        }

        elseif ($user->type === "employe") {
            $approvisionnement = $query->where('fk_createur' ,$user->id)->paginate(6);
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('Users.produits.approvisionnement', compact('approvisionnement', 'fournisseurs' , 'produits'))->render(),
            ]);
        }

        return view('Users.produits.approvisionnement' , compact('approvisionnement', 'fournisseurs' , 'produits'));
    }

    public function reapprovisionnement(Request $request){
        $fk_boutique = session('boutique_active_id');
        $user = Auth::user();

        $messages = [
            'fk_fournisseur.required' => 'veuillez selectionner un fournisseur',
            'fk_produit' => 'veuillez selectionner un produit',
            'qte_ajoutee' => 'veuillez remplir la quantite',
        ];

        $validated = $request->validate([
            'fk_fournisseur' => 'required',
            'fk_produit' => 'required',
            'qte_ajoutee' => 'required',
        ] , $messages);

        $reapprovisionnement = Reapprovisionnement::create([
            'fk_fournisseur' => $validated['fk_fournisseur'],
            'fk_produit' => $validated['fk_produit'],
            'qte_ajoutee' => $validated['qte_ajoutee'],
            'fk_createur' => $user->id,
            'fk_boutique' => $fk_boutique,
            'date_reapprovisionnement' =>  now()->toDateString(),
        ]);

        $fk_produit = $request->fk_produit;
        $produit = Produit::where('id' , $fk_produit)->first();
        $produit->qte_restante += $request->qte_ajoutee;
        $produit->save();

        $reapprovisionnement->load(['fournisseur' , 'produit']);

        $message = " l'utilisateur {$user->name} a validé un approvisionnement de {$reapprovisionnement->qte_ajoutee} sur le produit {$reapprovisionnement->produit->nom_produit} venant du fournisseur : {$reapprovisionnement->fournisseur->nom_fournisseur}";
        $description = "reapprovisionnement de produit" ;

        Suggestion::create([
            "description" => $description,
            "message" => $message,
            "direction" => "admin",
            "type_operation" => "notification",
            "status" => "attente",
            'fk_createur' => $user->id,
            'fk_boutique' => $fk_boutique,
        ]);


        return back()->with('approv_success' , 'qte du produit ajoutee avec succes');
    }

    public function annuler_approvisionnement($id){

        $approv = Reapprovisionnement::find($id);
        $id_produit = $approv->fk_produit;
        $produit = Produit::find($id_produit);
        $produit->qte_restante -= $approv->qte_ajoutee;
        $produit->save();
        $approv->delete();

        return back()->with('approv_delete' , 'reapprovisionnement annulé');
    }

    public function update_approvisionnement(Request $request , $id){

        $approvisionnement = Reapprovisionnement::find($id);

        $approvisionnement->fk_produit = $request->fk_produit;
        $approvisionnement->fk_fournisseur = $request->fk_fournisseur;
        $approvisionnement->qte_ajoutee = $request->qte_ajoutee;

        $approvisionnement->save();

        return back()->with('approv_updated' , 'approvisionnemet modifié avec succès');

    }
}
