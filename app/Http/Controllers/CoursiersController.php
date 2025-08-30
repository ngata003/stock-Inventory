<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Coursier;
use App\Models\Package;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CoursiersController extends Controller
{
    //

    public function coursiers_view(Request $request){
        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');
        $search = $request->input('coursier');
        $query =  Coursier::where('fk_boutique', $fk_boutique) ;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nom_coursier', 'LIKE', "%{$search}%")
                ->orWhere('contact', 'LIKE', "%{$search}%");
            });
        }


        $coursiers = $query->where('fk_createur', $user->id)->paginate(6);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('Users.coursiers', compact('coursiers'))->render(),
            ]);
        }

        return view('Users.coursiers', compact('coursiers'));
    }

    public function add_coursiers(Request $request){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');
        $boutiques_id =  Boutique::where('fk_createur' , $user->id)->pluck('id');
        $total_coursiers = Coursier::where('fk_createur', $user->id)->whereIn('fk_boutique' , $boutiques_id)->count();

        $coursiers_package = Package::where('fk_createur', $user->id)->first();
        $nb_coursiers = $coursiers_package->nb_coursiers;



        if($total_coursiers >= $nb_coursiers){
            return back()->with("error_nb_coursier" , "desole vous avez déjà crée tous les $nb_coursiers coursier(s) de votre package.");
        }

        $messages = [
            'nom_coursier.required' => 'veuillez saisir le nom du coursier',
            'nom_coursier.regex' => 'veuillez entrer un nom avec les lettres uniquement pas de chiffres',
            'nom_coursier.unique' => 'ce nom existe deja dans votre  boutique',
            'contact.required' => 'veuillez entrer un contact dans le champ contact',
            'contact.regex' => 'veuillez entrer un contact au format normal',
            'contact.unique'=> 'changez ce numero , il existe déjà',
            'adresse.required' => 'veuillez saisir l\'adresse dans le champ adresse',
            'image_cni.image' => 'veuillez uniquement entrer une image pas de vidéos',
            'image_cni.mimes' =>'veuillez entrer une image du format jpeg , jpg, png , gif',
        ];

        $validated = $request->validate([
            'nom_coursier' => ['required','string','regex:/^[a-zA-Z\s]+$/',Rule::unique('coursiers')->where('fk_boutique', $fk_boutique)],
            'contact' => ['required','string','regex:/^\+?[0-9]{7,15}$/',Rule::unique('coursiers')->where('fk_boutique', $fk_boutique)],
            'adresse' => 'required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
            'image_cni' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], $messages);

        if ($request->hasFile('image_cni')) {
            $image_cni = $request->file('image_cni');
            $logoName = uniqid('logo_') . '.' . $image_cni->getClientOriginalExtension();
            $image_cni->move(public_path('assets/images'), $logoName);
        } else {
            $logoName = null;
        }

        Coursier::create([
            'nom_coursier' => $validated['nom_coursier'],
            'contact' => $validated['contact'],
            'adresse' => $validated['adresse'],
            'image_cni' => $logoName,
            'fk_boutique' => $fk_boutique,
            'fk_createur' => $user->id,
        ]);

        return back()->with('coursier_creation' , 'coursier crée avec succès');

    }


    public function delete_coursiers($id){
        $coursier = Coursier::find($id);
        $coursier->delete();

        return back()->with('delete_status' , 'coursier supprimé avec succès');
    }

    public function update_coursiers(request $request , $id){

        $coursier = Coursier::find($id);

        $coursier->nom_coursier = $request->input('nom_coursier');
        $coursier->contact = $request->input('contact');
        $coursier->adresse = $request->input('adresse');

        if ($request->hasFile('image_cni')) {
            if ($coursier->image_cni) {
                $oldImagePath = public_path('assets/images' . $coursier->image_cni);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $image = $request->file('image_cni');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images'), $imageName);
            $coursier->image_cni = $imageName;
        }

        $coursier->save();

        return back()->with('update_coursiers' , 'coursier modifié avec succès');
    }
}
