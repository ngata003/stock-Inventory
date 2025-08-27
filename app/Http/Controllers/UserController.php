<?php

namespace App\Http\Controllers;

use App\Mail\PasswordEmployesMail;
use App\Mail\PasswordResetEmail;
use App\Models\Boutique;
use App\Models\Role;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Mail;
use Str;

class UserController extends Controller
{
    //

    public function signup(Request $request)
    {

        $messages = [
            'name.required' => 'Le nom est obligatoire.',
            'name.unique' => 'Ce nom est déjà utilisé.',
            'name.regex' => 'veuillez entrer un nom constitué de lettres',
            'email.required' => 'L\'email est obligatoire.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'contact.required' => 'Le contact est obligatoire.',
            'contact.unique' => 'Ce contact est déjà utilisé.',
            'contact.max' => 'Le contact ne peut pas dépasser 15 caractères.',
            'profil.image' => 'Le profil doit être une image.',
            'role.required' => 'Le rôle est obligatoire.',
            'type.required' => 'Le type est obligatoire.',
        ];

        $validated =  $request->validate([
            'name' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:12',
            'contact' => 'required|string|max:15|unique:users',
            'profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'role' => 'required|string',
            'type' => 'required|string',
        ] , $messages);

        if ($request->hasFile('profil')) {
            $image = $request->file('profil');
            $imageName = uniqid('profil_') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images'), $imageName);
        } else {
            $imageName = null;
        }

        // Create the user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' =>  Hash::make($validated['password']),
            'contact' => $validated['contact'],
            'profil' => $imageName,
            'role' => $validated['role'],
            'type' => $validated['type'],
        ]);

        return redirect()->route('login')->with('success', 'Inscription réussie !');
    }

    //code du login
    public function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $remember = $request->has('remember');

        if (auth()->attempt($credentials, $remember)) {
            $user = Auth::user();
            $user->status_connexion = 1;
            $user->save();

            if ($user->type === "admin") {

                if (!$user->package_choice) {
                    return redirect()->route('packages');
                }

                else{
                    return redirect()->route('boutiques_view')->with('success', 'Connexion réussie !');
                }
            }

            elseif($user->type === "employe"){
                $boutique = Boutique::where('id',$user->fk_boutique)->first();
                if($boutique){
                    session([
                        'boutique_active_id' => $boutique->id,
                        'boutique_nom' => $boutique->nom_boutique,
                        'boutique_logo' => $boutique->logo,
                    ]);

                    return redirect()->route('produits')->with('success', 'Connexion réussie !');

                } else {
                    return redirect()->back()->withErrors(['email' => 'Aucune boutique associée trouvée.']);
                }
            }

            elseif($user->type === "superadmin"){
                return redirect()->route('statistiques_SA');
            }
        }

        return redirect()->back()->withErrors(['email' => 'Identifiants invalides.']);
    }

    public function employes_view(){

        $user = Auth::user();
        $fk_boutique = session('boutique_active_id');

        if ($user->type === "admin") {
            $gestionnaires = User::where('fk_boutique' , $fk_boutique)->where('fk_createur' , $user->id)->paginate(6);
            $roles = Role::all();
        }
        elseif ($user->type === "superadmin") {
            $gestionnaires = User::all();
            $roles = Role::all();
        }


        return view('Admin.gestionnaires',compact('gestionnaires','roles'));

    }

    public function add_employes(Request $request){

        $fk_boutique = session('boutique_active_id');
        $user = Auth::user();

        $messages = [
            'name.required' => 'le nom est obligatoire',
            'name.regex' => 'entrez un nom qui commence par une lettre',
            'name.unique' => 'veuillez changer ce nom il est déjà enregistré',
            'email.required' => 'veuillez saisir l\'adresse email de l\'employé',
            'email.unique' => 'veuillez changer d\'adresse email , celle-ci existe déjà',
            'adresse.required' => 'veuillez remplir la case de l\'adresse ',
            'adresse.regex' => 'veuillez remplir une adresse qui commence par une lettre ',
            'role.required' => 'le champ de role est important',
            'profil.image' => 'le fichier enregistré doit etre une image',
            'profil.mimes' => 'l\'image telechargé doit avoir l\'une des extensions suivante: jpg , jpeg, gif, png',
            'piece_identite.image' => 'le fichier enregistré doit etre une image',
            'piece_identite.mimes' => 'l\'image telechargé doit avoir l\'une des extensions suivante: jpg , jpeg, gif, png',
        ];

        $validated = $request->validate([

            'name' => 'required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/|unique:users',
            'email' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z][a-zA-Z0-9_.+-]*@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'contact' => ['required', 'string', 'regex:/^\+?[0-9]{7,15}$/','unique:users'],
            'adresse' => 'required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
            'role' => 'required',
            'profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'piece_identite' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

        ], $messages);

        $password = Str::random(10);
        $password_hashed = bcrypt($password);

        if ($request->hasFile('profil')) {
            $profil_user = $request->file('profil');
            $profil = uniqid('profil_') . '.' . $profil_user->getClientOriginalExtension();
            $profil_user->move(public_path('assets/images'), $profil);
        } else {
            $profil = null;
        }
         if ($request->hasFile('piece_identite')) {
            $piece = $request->file('piece_identite');
            $piece_identite = uniqid('identite_') . '.' . $piece->getClientOriginalExtension();
            $piece->move(public_path('assets/images'), $piece_identite);
        } else {
            $piece_identite = null;
        }


        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'role' => $validated['role'],
            'type' => 'employe',
            'adresse' => $validated['adresse'],
            'profil' => $profil,
            'password' => $password_hashed,
            'piece_identite' => $piece_identite,
            'fk_boutique' => $fk_boutique,
            'fk_createur' => $user->id,
        ]);



        $link = "https://camestocks.com/login";
        Mail::to($validated['email'])->send( new PasswordEmployesMail($validated['email'], $validated['name'] , $password , $link));


        return back()->with('gestionnaires_creation' , 'employé crée avec succès');
    }


    public function delete_employes($id){

        $employe = User::find($id);
        $employe->delete();

        return back()->with('delete_employes' , 'gestionnaire supprimé avec succès');
    }

    public function update_employes(Request $request , $id){

        $employe = User::find($id);

        $messages = [
            'name.required' => 'veuillez remplir la case de nom',
            'name.unique' => 'ce nom existe déjà veuillez le changer',
            'email.required' => 'le champ email est obligatoire',
            'email.unique' => 'l\'email existe déjà , veuillez le changer',
            'contact.required' => 'le champ contact est obligatoire',
            'contact.unique' => 'le numero existe déjà , changez le',
            'role.required' => 'veuillez entrer un role a l\'utilisateur',
            'profil.image' => 'le profil doit etre une image',
            'profil.mimes' => 'le profil doit avoir les extensions suivantes: pg,jpeg,png,gif',
            'profil.max' => 'le profil doit etre une image de taille maximale egale à 2mo',
            'piece_identite.image' => 'le profil doit etre une image',
            'piece_identite.mimes' => 'le profil doit avoir les extensions suivantes: pg,jpeg,png,gif',
            'piece_identite.max' => 'le profil doit etre une image de taille maximale egale à 2mo',
        ];

        $validated = $request->validate([
            'name' => "required|string|max:255|unique:users,name,{$id}",
            'email' => "required|email|max:255|unique:users,email,{$id}",
            'contact' => "required|string|max:15|unique:users,contact,{$id}",
            'adresse' => 'required|string|max:255',
            'role' => 'required|string',
            'profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'piece_identite' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ] , $messages);


        if ($request->hasFile('profil')) {
            if ($employe->profil) {
                $oldImagePath = public_path('assets/images/' . $employe->profil);
                if (file_exists($oldImagePath)) unlink($oldImagePath);
            }

            $profil = $request->file('profil');
            $profilName = time() . '_' . uniqid() . '.' . $profil->getClientOriginalExtension();
            $profil->move(public_path('assets/images'), $profilName);
            $employe->profil = $profilName;
        }

        if ($request->hasFile('piece_identite')) {
            if ($employe->piece_identite) {
                $oldImagePath = public_path('assets/images/' . $employe->piece_identite);
                if (file_exists($oldImagePath)) unlink($oldImagePath);
            }

            $imagePiece = $request->file('piece_identite');
            $pieceName = time() . '_' . uniqid() . '.' . $imagePiece->getClientOriginalExtension();
            $imagePiece->move(public_path('assets/images'), $pieceName);
            $employe->piece_identite = $pieceName;
        }

        $employe->name = $validated['name'];
        $employe->email = $validated['email'];
        $employe->adresse = $validated['adresse'];
        $employe->contact = $validated['contact'];
        $employe->role = $validated['role'];

        $employe->save();

        return back()->with('gestionnaires_updated' , 'employé modifié avec succès');

    }


    public function profil_user(){

        $utilisateur = Auth::user();
        $user = User::find($utilisateur->id);

        return view('Users.profil_user' , compact('user'));
    }

    public function update_profil(Request $request , $id){

        $user = User::find($id);

        $messages = [
            'name.required' => 'veuillez remplir la case de nom',
            'name.unique' => 'ce nom existe déjà veuillez le changer',
            'email.required' => 'le champ email est obligatoire',
            'email.unique' => 'l\'email existe déjà , veuillez le changer',
            'contact.required' => 'le champ contact est obligatoire',
            'contact.unique' => 'le numero existe déjà , changez le',
            'profil.image' => 'le profil doit etre une image',
            'password.max' => 'le mot de passe doit etre inferieur ou égal à 12 caractères',
            'profil.mimes' => 'le profil doit avoir les extensions suivantes: pg,jpeg,png,gif',
            'profil.max' => 'le profil doit etre une image de taille maximale egale à 2mo',
        ];

        $validated = $request->validate([
            'name' => "required|string|max:255|unique:users,name,{$id}",
            'email' => "required|email|max:255|unique:users,email,{$id}",
            'contact' => "required|string|max:15|unique:users,contact,{$id}",
            'adresse' => 'required|string|max:255',
            'profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'password' => 'nullable|string|max:12',
        ] , $messages);


        if ($request->hasFile('profil')) {
            if ($user->profil) {
                $oldImagePath = public_path('assets/images/' . $user->profil);
                if (file_exists($oldImagePath)) unlink($oldImagePath);
            }

            $profil = $request->file('profil');
            $profilName = time() . '_' . uniqid() . '.' . $profil->getClientOriginalExtension();
            $profil->move(public_path('assets/images'), $profilName);
            $user->profil = $profilName;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->adresse = $validated['adresse'];
        $user->contact = $validated['contact'];
        $user->password = bcrypt($validated['password']);

        $user->save();

        return back()->with('profil_updated' , 'profil modifié avec succès');
    }

    public function logout(){
        $user = Auth::user();

        if($user){
            $user->status_connexion = 0;
            $user->save();
        }

        Auth::logout();
        return redirect()->route('login');
    }

    public function reset_password(){

        return view('Users.auth.password_forget');
    }

   public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé.']);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetUrl = route('reset.password.form', ['token' => $token]) . '?email=' . urlencode($request->email);

        Mail::to($request->email)->send(new PasswordResetEmail($request->email, $resetUrl));

        return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
    }

    public function showResetForm($token, Request $request)
    {
        return view('Users.auth.reset_password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Token invalide ou expiré.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Utilisateur introuvable.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Mot de passe réinitialisé avec succès.');
    }
}
