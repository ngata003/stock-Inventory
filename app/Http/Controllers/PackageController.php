<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Paiement;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //

    public function add_package(Request $request)
    {

        $id_user = Auth::user()->id;
        $user = User::where('id' , $id_user)->first();
        $user_package = Package::where('fk_createur', $id_user)->first();


        if ($user_package) {
            return back()->with('erro_package','vous avez déjà un package choisi , par consequent vous devez juste modifier si l\'offre ne vous interesse plus.');
        }

        $validated = $request->validate([
            'type_package' => 'required|string|max:255',
            'prix_abonnement'=> 'required|numeric|min:0',
            'nb_boutiques' => 'required|integer|min:1',
            'nb_employes' => 'required|integer|min:1',
            'nb_coursiers' => 'required|integer|min:1',
        ]);


        Package::create([
            'fk_createur' => $id_user,
            'type_package' => $validated['type_package'],
            'prix_abonnement' => $validated['prix_abonnement'],
            'nb_boutiques' => $validated['nb_boutiques'],
            'nb_employes' => $validated['nb_employes'],
            'nb_coursiers' => $validated['nb_coursiers'],
        ]);

        $user->package_choice = 1;
        $user->save();


        return redirect()->route('paiement_view')->with('success', 'Package ajouté avec succès !');
    }

    //fonction pour modifier le plan d'abonnement
    public function update_plan(Request $request)
    {
        $user_id = Auth::user()->id;

        $validated = $request->validate([
            'type_package' => 'required|string|max:255',
            'prix_abonnement'=> 'required|numeric|min:0',
            'nb_boutiques' => 'required|integer|min:1',
            'nb_employes' => 'required|integer|min:1',
            'nb_coursiers' => 'required|integer|min:1',
        ]);

        $user_package = Package::where('fk_createur', $user_id)->first();

        if ($user_package) {
             $user_package->update([
                'type_package' => $validated['type_package'],
                'prix_abonnement' => $validated['prix_abonnement'],
                'nb_boutiques' => $validated['nb_boutiques'],
                'nb_coursiers' => $validated['nb_coursiers'],
                'nb_employes' => $validated['nb_employes'],
            ]);

            return redirect()->route('statistiques')->with('success', 'Package mis à jour avec succès !');
        }

        return back()->with('error_package', 'vous n\'avez pas de package choisi');

    }

    public function update_view(){
        return view('Admin.package_update');
    }



}
