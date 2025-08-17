<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_client',
        'telephone',
        'adresse',
        'email',
        'fk_createur',
        'fk_boutique',
    ];

     public function boutiques(){
        return $this->belongsTo(Boutique::class, 'fk_boutique');
    }

    public function createurs(){
        return $this->belongsTo(User::class , 'fk_createur');
    }
}
