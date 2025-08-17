<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_package',
        'prix_abonnement',
        'fk_createur',
        'nb_coursiers',
        'nb_boutiques',
        'nb_employes',
    ];

}
