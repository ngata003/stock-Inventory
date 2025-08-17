<?php

namespace App\Http\Controllers;

use App\Mail\suggestions;
use App\Models\Suggestion;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Mail;

class suggestionsController extends Controller
{
    //
    public function suggestions_view(){
        $superadmin = User::where('type' , 'superadmin')->first();
        return view('admin.suggestions' , compact('superadmin'));
    }

    public function send_suggestions(Request $request){

        $fk_createur = Auth::user()->id;
        $fk_boutique = session('boutique_active_id');
        $validated = $request->validate([
            'message' => 'required|string|max:255|regex:',
        ]);

        Suggestion::create([
            'message' => $validated['message'],
            'fk_apg' => $fk_createur,
            'fk_boutique' => $fk_boutique,
        ]);

        Mail::to('storecames@gmail.com')->send( new suggestions($request->nom_admin,$request->nom_boutique,  $request->message));

        return back()->with('succes_suggestions' , 'suggestion envoyé à l\'administrateur réussi');
    }
}
