<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'profil',
        'role',
        'type',
        'adresse',
        'fk_createur',
        'fk_boutique',
        'piece_identite',
        'status_connexion',
        'package_choice',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function coursier(){
        return $this->hasMany(Coursier::class , 'fk_createur');
    }

    public function client(){
        return $this->hasMany(Client::class ,'fk_createur');
    }

    public function role(){
        return $this->hasMany(Role::class , 'fk_createur');
    }

    public function categorie(){
        return $this->hasMany(Categorie::class , 'fk_createur');
    }

    public function produit(){
        return $this->hasMany(Produit::class , 'fk_createur');
    }

    public function fournisseur(){
        return $this->hasMany(User::class , 'fk_createur');
    }

    public function suggestion(){
        return $this->hasMany(Suggestion::class ,'fk_createur');
    }
}
