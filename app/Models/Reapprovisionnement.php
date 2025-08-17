<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reapprovisionnement extends Model
{
    use HasFactory;
    protected $fillable = [
        'fk_produit',
        'fk_boutique',
        'fk_createur',
        'fk_fournisseur',
        'qte_ajoutee',
        'date_reapprovisionnement',
    ];

    public function createur(){
        return $this->belongsTo(User::class ,'fk_createur');
    }
    public function boutique(){
        return $this->belongsTo(Boutique::class ,'fk_boutique');
    }
    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class ,'fk_fournisseur');
    }
    public function produit(){
        return $this->belongsTo(Produit::class ,'fk_produit');
    }

}
