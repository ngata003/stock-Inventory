<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
     protected $fillable = [
        'categorie',
        'description',
        'fk_boutique',
        'fk_createur',
    ];

    public function boutiques(){
        return $this->belongsTo(Boutique::class, 'fk_boutique');
    }

    public function createurs(){
        return $this->belongsTo(User::class , 'fk_createur');
    }
}
