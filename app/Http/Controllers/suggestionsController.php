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
        return view('Admin.suggestions' , compact('superadmin'));
    }

    public function send_suggestions(Request $request){

        $fk_createur = Auth::user()->id;
        $fk_boutique = session('boutique_active_id');
        $messages = [
            'message.required' => 'veuillez remplir la case de message',
            'message.string' => 'rentrez une chaine de caractere',
            'message.regex' => 'veuillez rentrer une composition de lettres et de chiffres',
        ];

        $validated = $request->validate([
            'message' =>'required|string|max:255|regex:/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s.,!?;:()\'"-]+$/u',
            'type_operation' => 'required',
        ] , $messages);

        Suggestion::create([
            'message' => $validated['message'],
            'fk_createur' => $fk_createur,
            'fk_boutique' => $fk_boutique,
            'type_operation' => $validated['type_operation'],
        ]);

        Mail::to('storecames@gmail.com')->send( new suggestions($request->nom_admin,$request->nom_boutique,  $request->message));

        return back()->with('succes_suggestions' , 'suggestion envoyé à l\'administrateur réussi');
    }

    public function SA_suggestions(){
        $suggestions = Suggestion::where('direction' , 'superadmin')->paginate(6);

        return view('SuperAdmin.suggestions' , compact('suggestions'));
    }

    public function notifications  (Request $request , $mois = null){
        $fk_boutique = session('boutique_active_id');
        
        $mois = $request->mois ?? $mois;

        $notifications = Suggestion::where('fk_boutique' , $fk_boutique)
        ->orderBy('created_at','desc')->where('direction' ,'admin')
        ->when($mois, function ($query, $mois) {
            return $query->whereMonth('created_at', $mois);
        })
        ->where('type_operation' , 'notification')->paginate(6);

        return view('Admin.notifications' , compact('notifications'));
    }

    public function show_message($id){
        $notif = Suggestion::findOrFail($id);
        $notif->status = "lu";
        $notif->save();
        return response()->json($notif);
    }

    public function delete_notifications_admin($id){
        $notification = Suggestion::find($id);
        $notification->delete();

        return back()->with('notification_deleted' , 'notification supprimée');
    }
}
