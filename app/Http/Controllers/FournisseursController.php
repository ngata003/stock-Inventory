<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FournisseursController extends Controller
{
    //


    public function fournisseurs_view(Request $request){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');

        $search = $request->fournisseur ;
        $query = Fournisseur::where('fk_boutique',$fk_boutique );

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('nom_fournisseur', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('telephone', 'LIKE', "%{$search}%");
            });
        }

        if ($user->type === "admin") {
            $fournisseurs = $query->paginate(6);
        }

        elseif($user->type === "employe" ){
            $fournisseurs = $query->where('fk_createur' , $user->id)->paginate(6);
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('Users.produits.fournisseurs', compact('fournisseurs'))->render(),
            ]);
        }

        return view('Users.produits.fournisseurs' , compact('fournisseurs'));
    }


    public function add_fournisseurs(Request $request){

        $fk_createur = Auth::user()->id;
        $fk_boutique = session('boutique_active_id');

        $messages = [
            'nom_fournisseur.required' => 'veuillez remplir la case de nom fournisseur',
            'nom_fournisseur.unique' => 'ce nom existe deja dans cette boutique',
            'nom_fournisseur.regex' => 'veuillez entrer un nom valide commencant par une lettre',
            'adresse.required' => 'veuillez remplir le champs adresse',
            'adresse.regex' => 'entrez une adresse du genre douala , douala123',
            'telephone.required' => 'veuillez remplir la case de telephone',
            'telephone.regex' => 'entrez un numero de telephone valide',
            'telephone.unique' => 'ce numero existe déjà dans cette boutique',
            'email.required' => 'entrez remplir la case de l\'adresse email',
            'email.email' => 'veuillez renseigner une adresse email et non une chaine de caracteres',
            'email.unique' => 'cette adresse existe déjà dans cette boutique',
            'email.regex' => 'veuillez renseigner une adresse email valide au format aaaa@gmail.com ou aaa123@gmail.com'
        ];

        $validated = $request->validate([
            'nom_fournisseur' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ0-9\s\-]+$/|unique:fournisseurs,nom_fournisseur,NULL,id,fk_boutique,' . $fk_boutique,
            'email' => 'required|email|max:255|regex:/^[a-zA-Z][a-zA-Z0-9_.+-]*@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/|unique:fournisseurs,email,NULL,id,fk_boutique,' . $fk_boutique,
            'adresse' => 'required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
            'telephone' => ['required','string','regex:/^\+?[0-9]{7,15}$/',Rule::unique('fournisseurs')->where('fk_boutique', $fk_boutique)],
        ], $messages);


        Fournisseur::create([
            'nom_fournisseur' => $validated['nom_fournisseur'],
            'email' => $validated['email'],
            'adresse' => $validated['adresse'],
            'telephone' => $validated['telephone'],
            'fk_createur' => $fk_createur,
            'fk_boutique' => $fk_boutique,
        ]);

        return back()->with('success_add' , 'fournisseur ajouté avec succès');
    }

    public function update_fournisseurs(Request $request ,$id){

        $fk_boutique = session('boutique_active_id');

        $messages = [
            'nom_fournisseur.required' => 'veuillez remplir la case de nom fournisseur',
            'nom_fournisseur.unique' => 'ce nom existe deja dans cette boutique',
            'adresse.required' => 'veuillez remplir le champs adresse',
            'adresse.regex' => 'entrez une adresse du genre douala , douala123',
            'telephone.required' => 'veuillez remplir la case de telephone',
            'telephone.regex' => 'entrez un numero de telephone valide',
            'telephone.unique' => 'ce numero existe déjà dans cette boutique',
            'email.required' => 'entrez remplir la case de l\'adresse email',
            'email.email' => 'veuillez renseigner une adresse email et non une chaine de caracteres',
            'email.unique' => 'cette adresse existe déjà dans cette boutique',
            'email.regex' => 'veuillez renseigner une adresse email valide au format aaaa@gmail.com ou aaa123@gmail.com'
        ];

        $validated = $request->validate([
            'nom_fournisseur' => ['required','string','max:255',Rule::unique('fournisseurs', 'nom_fournisseur')->ignore($id)->where('fk_boutique', $fk_boutique)],
            'email' => ['required','email','max:255','regex:/^[a-zA-Z][a-zA-Z0-9_.+-]*@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',Rule::unique('fournisseurs', 'email')->ignore($id)->where('fk_boutique', $fk_boutique)],
            'adresse' => ['required','string','max:255','regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/'],
            'telephone' => ['required','string','regex:/^\+?[0-9]{7,15}$/',Rule::unique('fournisseurs', 'telephone')->ignore($id)->where('fk_boutique', $fk_boutique)
        ],
    ], $messages);


    $fournisseur = Fournisseur::find($id);

    $fournisseur->update([
        'nom_fournisseur' => $validated['nom_fournisseur'],
        'adresse' => $validated['adresse'],
        'telephone' => $validated['telephone'],
        'email' => $validated['email'],
    ]);

    return back()->with('fournisseur_updated' , 'fournisseur modifié avec succès');
    }

    public function delete_fournisseurs($id){
        $fournisseur = Fournisseur::find($id);
        $fournisseur->delete();

        return back()->with('fournisseurs_delete', 'fournisseur supprimé avec succès');
    }
}
