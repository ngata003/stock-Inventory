<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_client',
        'email_client',
        'contact_client',
        'montant_total',
        'montant_paye',
        'montant_remboursé',
        'date_vente',
        'status',
        'type_operation',
        'moyen_paiement',
        'fk_createur',
        'fk_coursier',
        'fk_boutique',
    ];

    public function coursiers(){
        return $this->belongsTo(Coursier::class ,'fk_coursier');
    }


}
