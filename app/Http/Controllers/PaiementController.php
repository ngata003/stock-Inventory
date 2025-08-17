<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Paiement;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    //

    public function add_paiement(Request $request){

        $messages = [
            'nom_depositaire.required' => 'renseignez le nom de celui qui a fait le depot',
            'nom_depositaire.regex' => 'entrez un nom valable pas de chiffres de lettres',
            'montant.required' => 'veuillez rentrer un montant',
        ];

        $request->validate([
            'nom_depositaire' => 'required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
            'montant' => 'required|numeric|min:0'
        ] , $messages);

        $user = Auth::user();
        $package_user = Package::where('fk_createur' , $user->id)->first();
        $today = now();
        $expiration = $today->copy()->addMonth();

        $prix_package = 700 * $package_user->prix_abonnement;

        if ((int)$prix_package !== (int)$request->montant) {
            return back()->with('error_paiement', 'Vous devez normalement payer ' . $prix_package . ' FCFA');
        }

        Paiement::create([
            'user_id' => $user->id,
            'nom_depositaire' => $request->nom_depositaire,
            'package_id' => $package_user->id,
            'montant' => $request->montant,
            'date_paiement' => $today,
            'date_expiration' => $expiration,
            'statut' => 'attente',
        ]);

        return redirect()->route('verification_paiement')->with('status' , 'enregistrement effectué avec succès , attendez la validation');
    }

    public function delete_pay($id){
        $pay = Paiement::find($id);
        $pay->delete();

        return back()->with('pay_deleted' , 'paiement supprimé avec succès');
    }

    public function valider_paiement($id){

        $pay = Paiement::find($id);
        $user = User::find( $pay->user_id);

        if ($user->date_expiration && Carbon::parse($user->date_expiration)->isFuture()) {
            $user->date_expiration = Carbon::parse($user->date_expiration)->addMonth();
        } else {
            $user->date_expiration = now()->addMonth();
        }

        $user->abonnement_valide = true;
        $user->save();

        $pay->statut = 'valide';
        $pay->save();

        return redirect()->back()->with('success_pay', 'Paiement validé avec succès.');
    }

    public function mes_paiements(){

        $user = Auth::user();
        $paiements = Paiement::where('user_id' , $user->id)->paginate(6);
        return view('Admin.mes_paiements' , compact('paiements'));
    }
}
