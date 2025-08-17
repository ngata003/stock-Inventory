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
        Schema::create('vente_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_vente');
            $table->string('nom_produit');
            $table->integer('qte');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('montant_total', 10, 2);
            $table->unsignedBigInteger('fk_createur');
            $table->unsignedBigInteger('fk_boutique');

            $table->foreign('fk_boutique')->references('id')->on('boutiques')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_createur')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_vente')->references('id')->on('ventes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vente_details');
    }
};
