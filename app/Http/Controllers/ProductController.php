<?php

namespace App\Http\Controllers;

use App\Mail\ProductSendMail;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Inventaire;
use App\Models\Produit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class ProductController extends Controller
{
    //

    public function product_view(){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');
        $categories = Categorie::where('fk_boutique' , $fk_boutique)->get();
        $fournisseurs = Fournisseur::where('fk_boutique' , $fk_boutique)->get();

        if($user->type === "admin"){

            $produits = Produit::with(['categorie' , 'fournisseur'])->where('fk_boutique' , $fk_boutique)->paginate(6);
            return view('Users.produits.produits', compact('produits' , 'categories','fournisseurs'));
        }
        else{

            $produits = Produit::with(['categorie' ,'fournisseur'])->where('fk_createur' , $user->id)->where('fk_boutique' , $fk_boutique)->paginate(6);
            return view('Users.produits.produits', compact('produits' , 'categories','fournisseurs'));
        }
    }

    public function add_products(Request $request)
    {
        $fk_boutique = session('boutique_active_id');
        $nom_boutique = session('boutique_nom');
        $user = Auth::user();

        $messages = [
            'nom_produit.required' => 'Veuillez remplir la case du nom de produit',
            'nom_produit.regex' => 'Le nom doit commencer par une lettre et ne peut contenir que des lettres, chiffres, espaces, tirets ou caractères accentués.',
            'nom_produit.unique' => 'Ce nom existe déjà dans votre collection de produits, veuillez le changer',
            'prix_vente.required' => 'Entrez le prix de vente',
            'prix_vente.numeric' => 'Le prix de vente doit être un nombre',
            'prix_achat.required' => 'Entrez le prix d\'achat',
            'prix_achat.numeric' => 'Le prix d\'achat doit être un nombre',
            'image_produit.image' => 'Le fichier doit être une image',
            'image_produit.mimes' => 'L\'image doit être de format png, jpg, jpeg ou gif',
            'image_produit.max' => 'L\'image ne doit pas dépasser 2 Mo',
            'qte_commandee.required' => 'Entrez la quantité du produit commandé',
            'description.regex' => 'La description doit commencer par une lettre et ne peut contenir que des lettres, chiffres, espaces, tirets ou caractères accentués',
            'fk_fournisseur.required' => 'veuillez selectionner un fournisseur',
            'fk_categorie.required' => 'selecctionnez une categorie',
        ];

        $validated = $request->validate([
            'nom_produit' => ['required','string','max:255','regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u',Rule::unique('produits')->where('fk_boutique', $fk_boutique)],
            'prix_vente' => 'required|numeric',
            'prix_achat' => 'required|numeric',
            'description' => 'nullable|string|regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u',
            'image_produit' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'qte_commandee' => 'required|integer',
            'fk_fournisseur'=>'required',
            'fk_categorie' => 'required',
        ], $messages);

        $productName = null;
        if ($request->hasFile('image_produit')) {
            $product = $request->file('image_produit');
            $productName = uniqid('prod_') . '.' . $product->getClientOriginalExtension();
            $product->move(public_path('assets/images'), $productName);
        }

        $initiales = strtoupper(substr(preg_replace('/\s+/', '', $validated['nom_produit']), 0, 3));
        $uniqueCode = 'PRD-' . $initiales . '-' . strtoupper(uniqid());
        $qrCodeFileName = $uniqueCode . '.png';
        $qrCodePath = public_path('assets/images/qrCodes/' . $qrCodeFileName);

        $qrImageBinary = QrCode::format('png')->size(250)->generate($uniqueCode);

        file_put_contents($qrCodePath, $qrImageBinary);

        if($request->prix_vente < $request->prix_achat){
            return back()->with('error_price' , 'le prix de vente ne peut pas etre inferieure au prix d\'achat veuillez modifier les prix.');
        }

        $product =Produit::create([
            'nom_produit' => $validated['nom_produit'],
            'prix_vente' => $validated['prix_vente'],
            'prix_achat' => $validated['prix_achat'],
            'description' => $validated['description'],
            'qte_commandee' => $validated['qte_commandee'],
            'qte_restante' => $validated['qte_commandee'],
            'fk_createur' => $user->id,
            'fk_boutique' => $fk_boutique,
            'image_produit' => $productName,
            'qr_code' => $qrCodeFileName,
            'benefice' => $validated['prix_vente'] - $validated['prix_achat'],
            'fk_categorie' => $validated['fk_categorie'],
            'fk_fournisseur' => $validated['fk_fournisseur'],
        ]);

        $message = " $user->name  a enregistré une quantité de $request->qte_commandee du produit $request->nom_produit ";

        Inventaire::create([
            'fk_boutique' => $fk_boutique,
            'description' => $message,
        ]);

        $clients = Client::where('fk_boutique', $fk_boutique)->get();
        foreach ($clients as $clt) {
            Mail::to($clt->email)->send(new ProductSendMail($product, $nom_boutique));
        }

        return back()->with('product_creation', 'Produit créé avec succès');
    }


    public function delete_produits($id){
        $produit = Produit::find($id);
        $produit->delete();

        return back()->with('product_deleted','produit supprimé avec succès');
    }

    public function update_produits(Request $request , $id){

        $fk_boutique = session('boutique_active_id');

        $produit = Produit::where('fk_boutique', $fk_boutique)->where('id' , $id)->firstOrFail();

        $messages = [
            'nom_produit.required' => 'Veuillez remplir la case du nom de produit',
            'nom_produit.regex' => 'Le nom doit commencer par une lettre et ne peut contenir que des lettres, chiffres, espaces, tirets ou caractères accentués.',
            'nom_produit.unique' => 'Ce nom existe déjà dans votre collection de produits, veuillez le changer',
            'prix_vente.required' => 'Entrez le prix de vente',
            'prix_vente.numeric' => 'Le prix de vente doit être un nombre',
            'prix_achat.required' => 'Entrez le prix d\'achat',
            'prix_achat.numeric' => 'Le prix d\'achat doit être un nombre',
            'image_produit.image' => 'Le fichier doit être une image',
            'image_produit.mimes' => 'L\'image doit être de format png, jpg, jpeg ou gif',
            'image_produit.max' => 'L\'image ne doit pas dépasser 2 Mo',
            'description.regex' => 'La description doit commencer par une lettre et ne peut contenir que des lettres, chiffres, espaces, tirets ou caractères accentués',
            'fk_categorie.required' => 'veuillez selectionner une categorie',
            'fk_fournisseur.required' => 'veuillez selectionner un fournisseur',
        ];

        $validated = $request->validate([
            'nom_produit' => ['required','string','max:255','regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u','regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u',Rule::unique('produits', 'nom_produit')->where(function ($query) use ($fk_boutique) {return $query->where('fk_boutique', $fk_boutique);})->ignore($id)],
            'prix_vente' => 'required|numeric',
            'prix_achat' => 'required|numeric',
            'description' => 'nullable|string|regex:/^\pL[\pL\pN\s\-\.\,\!\?\@\#\&\(\)\[\]\'\"\/\:\;\%]*$/u',
            'image_produit' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'fk_categorie' =>'required',
            'fk_fournisseur' => 'required',
        ], $messages);

        $produit = Produit::find($id);

        if ($request->hasFile('image_produit')) {
            if ($produit->logo) {
                $oldImagePath = public_path('assets/images' . $produit->image_produit);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('image_produit');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images'), $imageName);
            $produit->image_produit = $imageName;
        }

        $produit->nom_produit = $validated['nom_produit'];
        $produit->prix_achat = $validated['prix_achat'];
        $produit->prix_vente = $validated['prix_vente'];
        $produit->description =$validated['description'];
        $produit->fk_categorie =$validated['fk_categorie'];
        $produit->fk_fournisseur = $validated['fk_fournisseur'];
        $produit->benefice = $validated['prix_vente'] - $validated['prix_achat'];

        if (!$produit->produit_pris) {
            $produit->qte_commandee = $request->qte_commandee;
            $produit->qte_restante = $request->qte_commandee;
        }
        $produit->save();

        return back()->with('produits_updated', 'produit modifié avec succès');
    }

    public function autocompletion_produits(Request $request){

        $fk_boutique = session('boutique_active_id');
        $query = $request->get('query');

        if(!$query){
            return response()->json([]);
        }

        $produits = Produit::where('nom_produit','LIKE',"%{$query}%")->where('fk_boutique',$fk_boutique)->get(['nom_produit','prix_vente']);

        return response()->json($produits);
    }

}
