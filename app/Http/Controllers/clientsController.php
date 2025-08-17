<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class clientsController extends Controller
{
    //

    public function clients_view(){

        $fk_boutique = session('boutique_active_id');
        $user = Auth::user();

        if ($user->type === "admin") {
            $clients = Client::where('fk_boutique' , $fk_boutique)->paginate(6);
        }
        else {
            $clients = Client::where('fk_createur' , $user->id)->where('fk_boutique' , $fk_boutique)->paginate(6);
        }
        return view('Users.clients', compact('clients'));
    }

    public function add_clients(Request $request){

        $fk_createur = Auth::user()->id;
        $fk_boutique = session('boutique_active_id');

        $messages = [
            'nom_client.required' => 'veuillez remplir la case de nom du client',
            'nom_client.regex' => 'veuillez entrer un nom uniquement constitué des lettres majuscules ou miniscules',
            'nom_client.unique' => 'veuillez changer de nom car ce dernier existe deja dans votre boutique',
            'email.required' => 'veuillez remplir la case de l\' email ',
            'email.regex' => 'veuillez entrer une adresse email conforme',
            'email.unique' => 'veuillez entrer une autre adresse email celle ci existe déjà',
            'adresse.required' => 'veuillez remplir la case de l\'adresse',
            'adresse.regex' => 'entrer des lettres et des chiffres ou les deux mais pas de chiffres',
            'telephone.required' => 'entrer un numero de telephone cette case est vide',
            'telephone.regex' => 'entrez un numero de telephone correct',
            'telephone.unique' => 'veuillez changer de numero de telephone celui-ci existe déjà',
        ];


        $validated = $request->validate([
            'nom_client' =>['required','string','regex:/^[a-zA-Z\s]+$/',Rule::unique('clients')->where('fk_boutique', $fk_boutique)] ,
            'email' => ['required','string','max:255','regex:/.../', Rule::unique('clients')->where('fk_boutique', $fk_boutique)],
            'adresse' => 'required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
            'telephone' => ['required','string','regex:/^\+?[0-9]{7,15}$/',Rule::unique('clients')->where('fk_boutique', $fk_boutique)],
        ], $messages);

        Client::create([
            'nom_client' => $validated['nom_client'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'fk_boutique' => $fk_boutique,
            'fk_createur' => $fk_createur,
        ]);

        return back()->with('client_creation' , 'client crée avec succès');
    }


    public function delete_customers($id){
        $customer = Client::find($id);
        $customer->delete();

        return back()->with('delete_customers', 'client supprimé avec succès');
    }

    public function update_customers(Request $request , $id){

        $customer = Client::find($id);
        $fk_boutique = session('boutique_active_id');

         $messages = [
            'nom_client.required' => 'veuillez remplir la case de nom du client',
            'nom_client.regex' => 'veuillez entrer un nom uniquement constitué des lettres majuscules ou miniscules',
            'nom_client.unique' => 'veuillez changer de nom car ce dernier existe deja dans votre boutique',
            'email.required' => 'veuillez remplir la case de l\' email ',
            'email.regex' => 'veuillez entrer une adresse email conforme',
            'email.unique' => 'veuillez entrer une autre adresse email celle ci existe déjà',
            'adresse.required' => 'veuillez remplir la case de l\'adresse',
            'adresse.regex' => 'entrer des lettres et des chiffres ou les deux mais pas de chiffres',
            'telephone.required' => 'entrer un numero de telephone cette case est vide',
            'telephone.regex' => 'entrez un numero de telephone correct',
            'telephone.unique' => 'veuillez changer de numero de telephone celui-ci existe déjà',
        ];

        $validated = $request->validate([
            'nom_client' => ['required','string','max:255',Rule::unique('clients', 'nom_client')->ignore($id)->where('fk_boutique', $fk_boutique)],
            'email' => ['required','email','max:255','regex:/^[a-zA-Z][a-zA-Z0-9_.+-]*@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',Rule::unique('clients', 'email')->ignore($id)->where('fk_boutique', $fk_boutique)],
            'adresse' => ['required','string','max:255','regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/'],
            'telephone' => ['required','string','regex:/^\+?[0-9]{7,15}$/',Rule::unique('clients', 'telephone')->ignore($id)->where('fk_boutique', $fk_boutique)
        ],
    ], $messages);

    $customer->update([
        'nom_client' => $validated['nom_client'],
        'adresse' => $validated['adresse'],
        'telephone' => $validated['telephone'],
        'email' => $validated['email'],
    ]);

    return back()->with('customer_updated' , 'client modifié avec succès');


    }
}
