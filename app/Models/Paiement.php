<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'montant',
        'package_id',
        'nom_depositaire',
        'date_paiement',
        'date_expiration',
        'status',
    ];

    public function Createurs(){
        return $this->belongsTo(User::class , 'user_id');
    }
    public function packages(){
        return $this->belongsTo(Package::class , 'package_id');
    }
}
