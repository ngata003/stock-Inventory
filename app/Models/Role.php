<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'fk_createur',
    ];

    public function administrateur(){
        return $this->belongsTo(User::class , 'fk_createur');
    }

    public function role_attribue(){
        return $this->hasMany(User::class , 'fk_createur');
    }
}
