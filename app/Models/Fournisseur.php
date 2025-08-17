<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_fournisseur',
        'telephone',
        'adresse',
        'fk_createur',
        'fk_boutique',
        'email',
    ];

    public function boutiques(){
        return $this->belongsTo(Boutique::class, 'fk_boutique');
    }

    public function createurs(){
        return $this->belongsTo(User::class , 'fk_createur');
    }

    /*public function reapprovisionnement(): void{
        return $this->hasMany(Reapprovionnement::class ,'fk_fournisseur');
    }*/
}
