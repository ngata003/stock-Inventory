<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategorieController extends Controller
{
    //
    public function categories_view(){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');

        if($user->type === "employe"){

            $categories = Categorie::where('fk_createur' , $user->id)->where('fk_boutique' , $fk_boutique)->paginate(6);
            return view('Users.produits.categories', compact('categories'));

        }

        elseif($user->type === "admin"){

            $categories = Categorie::paginate(6);
            return view('Users.produits.categories', compact('categories'));

        }
    }

    public function add_category(Request $request){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');

        $messages = [
            'categorie.required' => 'veuillez saisir le nom de la categorie',
            'categorie.regex' => 'la categorie doit commencer par une lettre et peut contenir des lettres, chiffres et caractères spéciaux.',
            'categorie.unique' => 'cette categorie a déjà été prise , veuillez la changer',
            'description.regex' => 'la description doit commencer par une lettre et peut contenir des lettres, chiffres et caractères spéciaux.',
        ];

        $validated = $request->validate([
            'categorie' => ['required','string','regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u',Rule::unique('categories')->where('fk_boutique', $fk_boutique)],
            'description' => ['nullable','string','regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u'],
        ], $messages);



        Categorie::create([
            'categorie' => $validated['categorie'],
            'description' => $validated['description'],
            'fk_boutique' => $fk_boutique,
            'fk_createur' => $user->id,
        ]);

        return back()->with('categorie_creation' , 'categoié créée avec succès');

    }

    public function delete_categories($id){
        $categorie = Categorie::find($id);
        $categorie->delete();
        return back()->with('categorie_deleted' , 'categorie supprimée avec succès');
    }

    public function update_categories(Request $request , $id){

        $fk_boutique = session('boutique_active_id');
        $categorie = Categorie::find($id);

        $messages = [
            'categorie.required' => 'veuillez saisir le nom de la categorie',
            'categorie.regex' => 'la categorie doit commencer par une lettre et peut contenir des lettres, chiffres et caractères spéciaux.',
            'categorie.unique' => 'cette categorie a déjà été prise , veuillez la changer',
            'description.regex' => 'la description doit commencer par une lettre et peut contenir des lettres, chiffres et caractères spéciaux.',
        ];

        $validated = $request->validate([
            'categorie' => ['required','string','regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u',Rule::unique('categories' , 'categorie')->ignore($id)->where('fk_boutique', $fk_boutique)],
            'description' => ['nullable','string','regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u'],
        ], $messages);


        $categorie->update([
        'categorie' => $validated['categorie'],
        'description' => $validated['description'],
    ]);

    return back()->with('categorie_updated' , 'catégorie modifiée avec succès');
    }
}
