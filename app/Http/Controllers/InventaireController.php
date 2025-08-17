<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use Auth;
use Illuminate\Http\Request;

class InventaireController extends Controller
{
    //

    public function notifications(){

        $fk_boutique = session('boutique_active_id');
        if (Auth::user()->type === "admin") {

            $notifications = Inventaire::where('fk_boutique' , $fk_boutique)->orderBy('created_at','desc')->get();
            return view('Users.notifications', compact('notifications'));
        }

    }
}
