<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_boutique',
        'adresse',
        'telephone',
        'email',
        'site_web',
        'logo',
        'fk_createur',
    ];

    public function createur(){
        return $this->belongsTo(User::class , 'fk_createur');
    }

    public function coursier(){
        return $this->hasMany(Coursier::class , 'fk_boutique');
    }

    public function client(){
        return $this->hasMany(Client::class , 'fk_boutique');
    }

    public function categorie_produit(){
        return $this->hasMany(categorie::class , 'fk_boutique');
    }

    public function produit(){
        return $this->hasMany(Produit::class ,'fk_boutique');
    }

    public function fournisseurs(){
        return $this->hasMany(Fournisseur::class , 'fk_boutique');
    }

    public function employes(){
        return $this->hasMany(User::class , 'fk_boutique');
    }

    public function suggestion(){
        return $this->hasManany(Suggestion::class , 'fk_boutique');
    }
}
