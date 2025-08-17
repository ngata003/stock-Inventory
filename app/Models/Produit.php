<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_produit',
        'prix_vente',
        'prix_achat',
        'benefice',
        'description',
        'qte_commandee',
        'qte_restante',
        'image_produit',
        'qr_code',
        'fk_boutique',
        'fk_createur',
        'fk_categorie',
        'fk_fournisseur',
    ];

     public function boutiques(){
        return $this->belongsTo(Boutique::class, 'fk_boutique');
    }

    public function createurs(){
        return $this->belongsTo(User::class , 'fk_createur');
    }

    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class ,'fk_fournisseur');
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class , 'fk_categorie');
    }
}
