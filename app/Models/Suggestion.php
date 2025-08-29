<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'fk_createur',
        'fk_boutique',
        'type_operation',
        'description',
        'status',
        'direction'
    ];


    public function createur(){
        return $this->belongsTo(User::class , 'fk_createur');
    }

    public function boutique(){
        return $this->belongsTo(Boutique::class , 'fk_boutique');
    }
}
