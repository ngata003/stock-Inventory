<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Auth;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //

    public function add_roles(Request $request){

        $messages = [
            'nom.unique' => 'ce role existe déjà , veuillez le changer',
            'nom.required' => 'veuillez remplir la case de nom de role',
            'nom.regex' => 'veuillez entrer uniquement de lettres pas de chiffres',
        ];

        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:roles|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/',
        ] , $messages);


        Role::create([
            'nom' => $validated['nom'],
            'fk_createur' => $user->id,
        ]);

        return back()->with('role_creation' , 'role crée avec succès');
    }

    public function roles_view(Request $request){

        $search = $request->role ;
        $query = Role::query();

        if($search){
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%");
            });
        }

        $roles =$query->paginate(6);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('SuperAdmin.roles', compact('roles'))->render(),
            ]);
        }
        return view('SuperAdmin.roles', compact('roles'));

    }

    public function delete_roles($id){

        $role = Role::find($id);
        $role->delete();

        return back()->with('role_deleted' , 'role supprimé avec succès');
    }

    public function update_roles(Request $request , $id){

        $role = Role::find($id);

        $messages = [
            'nom.unique' => 'ce role existe déjà , veuillez le changer',
            'nom.required' => 'veuillez remplir la case de nom de role',
            'nom.regex' => 'veuillez entrer uniquement de lettres pas de chiffres',
        ];

        $validated = $request->validate([
            'nom' => "required|string|max:255|regex:/^[a-zA-Z][a-zA-Z0-9\s\-]*$/|unique:roles,nom,{$id}",
        ] , $messages);

        $role->nom = $validated['nom'];
        $role->save();

        return back()->with('role_updated' , 'role modifié avec succès');

    }
}
