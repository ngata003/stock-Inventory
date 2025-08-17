<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coursier extends Model
{
    use HasFactory;

     protected $fillable = [
        'nom_coursier',
        'contact',
        'adresse',
        'image_cni',
        'fk_createur',
        'fk_boutique',
    ];

    public function boutiques(){
        return $this->belongsTo(Boutique::class, 'fk_boutique');
    }

    public function createurs(){
        return $this->belongsTo(User::class , 'fk_createur');
    }

    public function vente(){
        return $this->hasMany(Vente::class ,'fk_coursier');
    }
}
