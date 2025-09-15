<?php

namespace App\Http\Controllers;

use App\Mail\FactureClientMail;
use App\Models\Boutique;
use App\Models\Coursier;
use App\Models\Suggestion;
use App\Models\Produit;
use App\Models\Vente;
use App\Models\vente_detail;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;

class VentesController extends Controller
{
    //

    public function ventes_view(){


        return view('Users.ventes.ventes');
    }

    public function commandes_view(){

        $fk_boutique = session('boutique_active_id');

        $coursiers = Coursier::where('fk_boutique' , $fk_boutique)->get();

        return view('Users.ventes.commandes' , compact('coursiers'));
    }

    public function add_ventes(Request $request)
    {
        $messages = [
            'email_client.email' => 'Veuillez entrer une adresse email valide.',
            'email_client.regex' => 'L\'adresse email doit commencer par une lettre et respecter le format correct (ex: exemple@mail.com).',
            'montant_total.required' => 'Le montant total est obligatoire.',
            'montant_total.numeric' => 'Le montant total doit être un nombre.',
            'nom_client.regex' => 'le nom du client doit avoir uniquement les lettres',
            'montant_rembourse.numeric' => 'le montant remboursé doit etre un chiffre',
            'montant_paye.numeric' => 'le montant payé doit etre un nombre',
        ];

        $request->validate([
            'nom_client'=>'nullable|regex:/^[a-zA-Z]+$/',
            'email_client' => 'nullable|email|regex:/^[a-zA-Z][a-zA-Z0-9_.+-]*@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'montant_total'=>'required|numeric',
            'montant_paye'=>'nullable|numeric',
            'montant_rembourse'=>'nullable|numeric',
            'moyen_paiement'=>'nullable|string',
            'type_operation' => 'required',
            'fk_coursier' => 'nullable',
            'contact_client' => 'nullable|regex:/^\+?[0-9]{7,15}$/',
        ] , $messages);

        $valeur = $request->input('numRows');
        $fk_boutique = session('boutique_active_id');
        $user = Auth::user();

        for ($i = 0; $i < $valeur; $i++) {
            $produit = Produit::where('nom_produit', $request->input('nom_produit'.$i))->first();
            $qteDemandee = $request->input('qte'.$i);

            if (!$produit) {
                    return back()->with("error_produit", "le produit $produit->nom_produit n'existe pas ");
                }

                if ($produit->qte_restante == 0) {
                    return back()->with("error_produit", " le produit $produit->nom_produit est terminé en stock");
                }

                if ($produit->qte_restante < $qteDemandee) {
                    return back()->with("error_produit", "stock insuffisant pour le produit $produit->nom_produit , il vous reste $produit->qte_restante");
            }

        }

        DB::beginTransaction();

        try {
            $facture = new Vente();
            $facture->nom_client = $request->nom_client;
            $facture->email_client = $request->email_client;
            $facture->montant_total = $request->montant_total;
            $facture->moyen_paiement = $request->moyen_paiement;
            $facture->montant_paye = $request->montant_paye;
            $facture->montant_remboursé = $request->montant_rembourse;
            $facture->type_operation = $request->type_operation;
            $facture->fk_boutique = $fk_boutique;
            $facture->fk_createur = $user->id;
            $facture->fk_coursier = $request->fk_coursier;
            $facture->contact_client = $request->contact_client;

            if ( $request->type_operation === "vente") {
                $facture->status = true;
            }
            elseif ($request->type_operation === "commande") {
                $facture->status = false;
            }
            $facture->date_vente = Carbon::now()->toDateString();
            $facture->save();

            $id_facture = $facture->id;
            $details = [];

            for ($i = 0; $i < $valeur; $i++) {
                $venteDetail = new vente_detail();
                $venteDetail->nom_produit = $request->input('nom_produit'.$i);
                $venteDetail->qte = $request->input('qte'.$i);
                $venteDetail->prix_unitaire = $request->input('prix_unitaire'.$i);
                $venteDetail->montant_total = $request->input('montant_total'.$i);
                $venteDetail->fk_vente = $id_facture;
                $venteDetail->fk_createur = $user->id;
                $venteDetail->fk_boutique = $fk_boutique;
                $venteDetail->save();

                $details[] = $venteDetail;

                $produit = Produit::where('nom_produit', $venteDetail->nom_produit)->first();
                $produit->qte_restante -= $venteDetail->qte;
                $produit->save();

            }

            if($request->type_operation === "vente"){

                $message = "l'utilisateur {$user->name} a enregistré une vente d'un total de {$request->montant_total} du client de nom {$request->nom_client} et de mail: {$request->email_client}";
                $description = " nouvelle vente ";

                Suggestion::create([
                    'description' => $description,
                    'message' => $message,
                    'fk_boutique' => $fk_boutique,
                    'fk_createur' => $user->id,
                    'status' => "attente",
                    'direction' => "admin",
                    'type_operation' => "notification",
                ]);
            }

            if($request->type_operation === "commande"){

                $message = "l'utilisateur {$user->name} a enregistré une commande d'un total de {$request->montant_total} du client de nom {$request->contact_client}";
                $description = " nouvelle vente ";

                Suggestion::create([
                    'description' => $description,
                    'message' => $message,
                    'fk_boutique' => $fk_boutique,
                    'fk_createur' => $user->id,
                    'status' => "attente",
                    'direction' => "admin",
                    'type_operation' => "notification",
                ]);
            }


            $boutique = Boutique::find($fk_boutique);
            $data = [
                'logo' => $boutique->logo,
                'date' => now()->format('Y-m-d'),
                'email' => $boutique->email,
                'contact' => $boutique->telephone,
                'site_web' => $boutique->site_web,
                'localisation' => $boutique->adresse,
                'id_facture' => $id_facture,
                'nom_client' => $request->nom_client,
                'email_client' => $request->email_client,
                'ventes' => $details,
                'montant_paye' => $request->montant_paye,
                'remboursement' => $request->montant_rembourse,
                'total_achat' => $request->montant_total,
            ];

            $pdf = Pdf::loadView('Users.ventes.facture', ['data' => $data]);
            /*$pdfPath = public_path('assets/PDF/facture_'.$id_facture.'.pdf');
            $pdf->save($pdfPath);*/

           /* if ($request->type_operation === "vente" && $request->email_client) {
                Mail::to($request->email_client)->send(new FactureClientMail($data, $pdfPath));
            }*/

            DB::commit();

          /*  if ($request->type_operation === "vente") {
                return redirect()->route('liste_ventes')->with('success_transfert' , 'facture enregistrée et envoyée au client avec succès');
            }

            elseif($request->type_operation === "commande"){
                return redirect()->route('liste_commandes')->with('success_transfert' , 'facture enregistrée et envoyée au client avec succès');
            }*/
            return $pdf->stream('facture'.$id_facture.'.pdf');


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_produit', 'Une erreur est survenue : '.$e->getMessage());
        }
    }


    public function liste_ventes( Request $request , $mois = null){
        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');

        $mois = $request->mois ?? $mois ;

        $search = $request->vente ;

        $query = Vente::where('fk_boutique' , $fk_boutique)
        ->where('type_operation','vente')
        ->whereYear('created_at' , now()->year)
        ->orderBy('created_at', 'desc')
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        });


        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('nom_client', 'LIKE', "%{$search}%");
            });
        }

        if($user->type === "admin"){
            $ventes = $query->paginate(6);
        }
        elseif ($user->type === "employe") {
            $ventes = $query->where('fk_createur' , $user->id)->paginate(6);
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('Users.ventes.liste_ventes', compact('ventes'))->render(),
            ]);
        }


        return view('Users.ventes.liste_ventes' , compact('ventes'));
    }

    public function delete_ventes($id)
    {
        $vente_details = vente_detail::where('fk_vente' , $id)->get();

        if ($vente_details->isEmpty()) {
            return back()->withErrors(['error' => 'Aucune vente trouvée pour cette facture.']);
        }

        foreach ($vente_details as $vente) {
            $produit = Produit::where('nom_produit', $vente->nom_produit)->first();
            if ($produit) {
                $produit->qte_restante += $vente->qte;
                $produit->save();
            }
        }

        vente_detail::where('fk_vente', $id)->delete();

        $facture = Vente::find($id);
        if ($facture) {
            $facture->delete();
        }

        return back()->with('invoice_delete' , 'Vente annulée et produits retournés avec succès');

    }

    public function update_ventes_view($id){

        $fk_boutique = session('boutique_active_id');
        $vente = Vente::find($id);
        $coursiers = Coursier::where('fk_boutique' , $fk_boutique);

        $vente_details = vente_detail::where('fk_boutique', $fk_boutique)->where('fk_vente' , $id)->get();
        $nbre_lignes = vente_detail::where('fk_boutique',$fk_boutique)->where('fk_vente',$id)->count();

        return view('Users.ventes.update_ven-com' , compact('vente_details' , 'nbre_lignes' , 'vente', 'coursiers'));
    }


    public function imprimer_factures($id){

        $boutique = Boutique::where('id' , session('boutique_active_id'))->first() ;

        if (!$boutique) {
            return redirect()->back()->withErrors(['error' => 'Aucune boutique active trouvée.']);
        }

        // Récupérer la facture et les ventes associées
        $ventes = vente_detail::where('fk_vente', $id)->get();
        $invoice = Vente::findOrFail($id);
        $date = now()->format('Y-m-d');

        $data = [
            'ventes' => $ventes,
            'date' => $date,
            'invoice' => $invoice,
            'boutique' => $boutique,
        ];

        $pdf = PDF::loadView('Users.ventes.facture_impression', $data);

        $toDaydate = Carbon::now()->format('d-m-y');

        return $pdf->stream('facture' . $invoice->id_facture . '-' . $toDaydate . '.pdf');
    }

    public function update_ventes(Request $request)
    {
        $messages = [
            'email_client.email' => 'Veuillez entrer une adresse email valide.',
            'email_client.regex' => 'L\'adresse email doit commencer par une lettre et respecter le format correct (ex: exemple@mail.com).',
            'montant_total.required' => 'Le montant total est obligatoire.',
            'montant_total.numeric' => 'Le montant total doit être un nombre.',
            'nom_client.regex' => 'Le nom du client doit avoir uniquement les lettres',
            'montant_rembourse.numeric' => 'Le montant remboursé doit être un chiffre',
            'montant_paye.numeric' => 'Le montant payé doit être un nombre',
        ];

        $request->validate([
            'nom_client'=>'nullable|regex:/^[a-zA-Z]+$/',
            'email_client' => 'nullable|email|regex:/^[a-zA-Z][a-zA-Z0-9_.+-]*@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'montant_total'=>'required|numeric',
            'montant_paye'=>'nullable|numeric',
            'montant_rembourse'=>'nullable|numeric',
            'moyen_paiement'=>'nullable|string',
            'type_operation' => 'required',
            'fk_coursier' => 'nullable',
            'contact_client' => 'nullable|regex:/^\+?[0-9]{7,15}$/',
        ], $messages);

        $valeur = $request->numRows;
        $fk_vente = $request->fk_vente;
        $fk_boutique = session('boutique_active_id');
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $facture = Vente::findOrFail($fk_vente);

            $anciensDetails = Vente_detail::where('fk_vente', $fk_vente)->get();
            foreach ($anciensDetails as $detail) {
                $produit = Produit::where('nom_produit', $detail->nom_produit)->first();
                if ($produit) {
                    $produit->qte_restante += $detail->qte;
                    $produit->save();
                }
            }

            Vente_detail::where('fk_vente', $fk_vente)->delete();

            $facture->nom_client = $request->nom_client;
            $facture->email_client = $request->email_client;
            $facture->montant_total = $request->montant_total;
            $facture->moyen_paiement = $request->moyen_paiement;
            $facture->montant_paye = $request->montant_paye;
            $facture->montant_remboursé = $request->montant_rembourse;
            $facture->type_operation = $request->type_operation;
            $facture->fk_boutique = $fk_boutique;
            $facture->fk_createur = $user->id;
            $facture->fk_coursier = $request->fk_coursier;
            $facture->contact_client = $request->contact_client;

            $facture->status = true;

            $facture->date_vente = Carbon::now()->toDateString();
            $facture->save();

            $details = [];

            for ($i = 0; $i < $valeur; $i++) {
                $produit = Produit::where('nom_produit', $request->input('nom_produit'.$i))->first();
                $qteDemandee = $request->input('qte'.$i);

                if (!$produit) {
                    return back()->with("error_produit", "le produit $produit->nom_produit n'existe pas ");
                }

                if ($produit->qte_restante == 0) {
                    return back()->with("error_produit", " le produit $produit->nom_produit est terminé en stock");
                }

                if ($produit->qte_restante < $qteDemandee) {
                    return back()->with("error_produit", "stock insuffisant pour le produit $produit->nom_produit , il vous reste $produit->qte_restante");
                }

                $venteDetail = new Vente_detail();
                $venteDetail->nom_produit = $request->input('nom_produit'.$i);
                $venteDetail->qte = $request->input('qte'.$i);
                $venteDetail->prix_unitaire = $request->input('prix_unitaire'.$i);
                $venteDetail->montant_total = $request->input('montant_total'.$i);
                $venteDetail->fk_vente = $facture->id;
                $venteDetail->fk_createur = $user->id;
                $venteDetail->fk_boutique = $fk_boutique;
                $venteDetail->save();

                $details[] = $venteDetail;

                $produit->qte_restante -= $qteDemandee;
                $produit->save();
            }


            $boutique = Boutique::find($fk_boutique);
            $data = [
                'logo' => $boutique->logo,
                'date' => now()->format('Y-m-d'),
                'email' => $boutique->email,
                'contact' => $boutique->telephone,
                'site_web' => $boutique->site_web,
                'localisation' => $boutique->adresse,
                'id_facture' => $facture->id,
                'nom_client' => $request->nom_client,
                'email_client' => $request->email_client,
                'ventes' => $details,
                'montant_paye' => $request->montant_paye,
                'remboursement' => $request->montant_rembourse,
                'total_achat' => $request->montant_total,
            ];

            $pdf = Pdf::loadView('Users.ventes.facture', ['data' => $data]);
            $pdfPath = public_path('assets/PDF/facture_'.$facture->id.'.pdf');
            $pdf->save($pdfPath);

            if ($request->type_operation === "vente" && $request->email_client) {
                Mail::to($request->email_client)->send(new FactureClientMail($data, $pdfPath));
            }

            DB::commit();

            return redirect()->route($request->type_operation === "vente" ? 'liste_ventes' : 'liste_commandes')
                ->with('success_transfert', 'Facture modifiée avec succès et stock mis à jour.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_produit', 'Une erreur est survenue : '.$e->getMessage());
        }
    }

}
