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


}
