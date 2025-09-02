<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Client;
use App\Models\Coursier;
use App\Models\Fournisseur;
use App\Models\Package;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class BoutiquesController extends Controller
{
    //

    public function add_boutique(Request $request){

        $user_id = Auth::id();
        //compter le nombre de boutiques de l'admin
        $nb_boutiques = Boutique::where('fk_createur',$user_id)->count();
        $user_package = Package::where('fk_createur', $user_id)->first();
        //recuperer le nombre de
        $nb_boutiques_package = $user_package->nb_boutiques;

        if ( $nb_boutiques  >= $nb_boutiques_package) {
            return back()->with('error_nb', 'vous ne pouvez plus creer de boutiques car votre package vous donne acces à' . ' ' . $nb_boutiques_package . ' boutique(s)');
        }

        $messages = [
            'nom_boutique.required' => 'veuillez remplir la case du nom de boutique',
            'nom_boutique.unique' => 'changez de nom de boutique car ce dernier existe déjà',
            'nom_boutique.regex' => 'Le nom de la boutique doit commencer par une lettre et ne pas être uniquement des chiffres.',
            'adresse.required' => 'veuillez remplir la case adresse',
            'adresse.regex' => 'entrez une bonne adresse',
            'telephone.required' => 'veuillez remplir la case de telephone ',
            'telephone.max' => 'entrez un vrai contact',
            'telephone.unique' => 'entrez un autre numero de telephone car celui ci existe déjà',
            'telephone.regex' => 'entrez un vrai numero de telephone',
            'email.required' => 'veuillez remplir la case email',
            'email.unique' => 'veuillez saisir un autre email car celui-ci existe déjà',
            'email.regex' => 'L\'adresse email doit commencer par une lettre.',
            'logo.image' => 'le logo choisi doit etre une image',
            'logo.mimes' => 'le logo choisi doit etre du format jpg , jpeg, png , gif',
            'logo.max' => 'le logo choisi ne doit pas depasser les 2Mo',
            'site_web.regex' => 'Veuillez entrer une URL valide comme cames_store.com ou https://cames_store.com.',
        ];

        $validated = $request->validate([
            'nom_boutique' => 'required|string|max:255|unique:boutiques|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
            'adresse' => '',
            'telephone' => ['required', 'string', 'regex:/^\+?[0-9]{7,15}$/','unique:boutiques'],
            'email' => 'required|string|max:255|unique:boutiques|regex:/^[a-zA-Z][a-zA-Z0-9_.+-]*@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'site_web' => 'nullable|string|max:255|regex:/^(https?:\/\/)?(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\/\S*)?$/',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], $messages);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = uniqid('logo_') . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('assets/images'), $logoName);
        } else {
            $logoName = null;
        }

        Boutique::create([
            'nom_boutique' => $validated['nom_boutique'],
            'adresse' => $validated['adresse'],
            'telephone' => $validated['telephone'],
            'email' => $validated['email'],
            'site_web' => $validated['site_web'],
            'logo' => $logoName,
            'fk_createur' => $user_id,
        ]);

        return back()->with('success_boutique','votre boutique créée avec succès');

    }

    public function store_view(){
        $user = Auth::user();
        $inf_boutiques = Boutique::where('fk_createur', $user->id)->paginate(6);
        $id_boutiques = Boutique::where('fk_createur' , $user->id)->pluck('id');
        $nbre_coursiers = Coursier::whereIn('fk_boutique', $id_boutiques)->count();
        $nbre_employes = User::whereIn('fk_boutique' , $id_boutiques)->count();
        $nbre_boutiques = Boutique::where('fk_createur' , $user->id)->count();
        $nbre_clients = Client::whereIn('fk_boutique' , $id_boutiques)->count();
        $nbre_fournisseurs = Fournisseur::whereIn('fk_boutique', $id_boutiques)->count();
        return view('Admin.boutiques' , compact('inf_boutiques' , 'nbre_employes' , 'nbre_coursiers' ,
         'nbre_boutiques' , 'nbre_clients' , 'nbre_fournisseurs'));
    }

    public function update_boutique(Request $request , $id){
        $boutique = Boutique::find($id);

        $boutique->nom_boutique = $request->input('nom_boutique');
        $boutique->adresse = $request->input('adresse');
        $boutique->telephone = $request->input('telephone');
        $boutique->email = $request->input('email');
        $boutique->site_web = $request->input('site_web');

        if ($request->hasFile('logo')) {
            if ($boutique->logo) {
                $oldImagePath = public_path('assets/images' . $boutique->logo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images'), $imageName);
            $boutique->logo = $imageName;
        }

        $boutique->save();

        return back()->with('boutique_update', 'boutique modifiée avec succès');

    }

    public function boutique_delete($id){
        $boutique = Boutique::find($id);
        $boutique->delete();

        return back()->with('boutique_deleted','boutique supptimée avec succès');
    }

    public function boutique_activation($id){

        $boutique = Boutique::find($id);

        session([
            'boutique_active_id' => $boutique->id,
            'boutique_nom' => $boutique->nom_boutique,
            'boutique_logo' => $boutique->logo,
        ]);

        return redirect()->route('statistiques');
    }

    public function boutiques_view(){

        $user = Auth::user();
        if ($user->type === "admin") {
            $boutiques = Boutique::where('fk_createur', $user->id)->get();
        }

        elseif ($user->type === "superadmin") {
            $boutiques = Boutique::all();
        }

        return view('boutiques', compact('boutiques'));
    }
}





