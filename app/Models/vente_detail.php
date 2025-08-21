<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vente_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_produit',
        'qte',
        'prix_unitaire',
        'montant_total',
        'fk_vente',
        'fk_createur',
        'fk_boutique',
    ];


    public function createur(){
        return $this->belongsTo(User::class , 'fk_createur');
    }

    public function boutique(){
        return $this->belongsTo(Boutique::class , 'fk_boutique');
    }

    public function vente(){
        return $this->belongsTo(Vente::class , 'fk_vente');
    }

}
