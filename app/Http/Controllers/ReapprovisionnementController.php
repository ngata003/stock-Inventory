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
    public function approvisionnement() {
        $fk_boutique = session('boutique_active_id');
        $user = Auth::user();
        if ($user->type === "admin") {
            $approvisionnement = Reapprovisionnement::with(['fournisseur' , 'produit'])->where('fk_boutique' , $fk_boutique)->paginate(6);
            $produits = Produit::where('fk_boutique' , $fk_boutique)->get();
            $fournisseurs = Fournisseur::where('fk_boutique', $fk_boutique)->get();
            return view('Users.produits.approvisionnement' , compact('approvisionnement', 'fournisseurs' , 'produits'));
        }
        elseif ($user->type === "employe") {
            $approvisionnement = Reapprovisionnement::with(['produit' , 'fournisseur'])->where('fk_boutique' , $fk_boutique)->where('fk_createur' ,$user->id)->paginate(6);
            $produits = Produit::where('fk_boutique' , $fk_boutique)->get();
            $fournisseurs = Fournisseur::where('fk_boutique', $fk_boutique)->get();
            return view('Users.produits.approvisionnement' , compact('approvisionnement' , 'produits' , 'fournisseurs'));
        }
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
