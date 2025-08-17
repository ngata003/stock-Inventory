<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom_produit');
            $table->string('description')->nullable();
            $table->string('prix_vente');
            $table->string('prix_achat');
            $table->string('benefice');
            $table->string('image_produit')->nullable();
            $table->unsignedBigInteger('fk_createur');
            $table->unsignedBigInteger('fk_boutique');

            $table->foreign('fk_createur')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_boutique')->references('id')->on('boutiques')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['nom_produit','fk_boutique']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
