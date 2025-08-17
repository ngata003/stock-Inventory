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
        Schema::create('reapprovisionnements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_produit');
            $table->integer('qte_ajoutee');
            $table->unsignedBigInteger('fk_fournisseur');
            $table->date('date_reapprovisionnement')->default(now());
            $table->unsignedBigInteger('fk_createur');
            $table->unsignedBigInteger('fk_boutique');

            $table->foreign('fk_produit')->references('id')->on('produits')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_fournisseur')->references('id')->on('fournisseurs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_createur')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_boutique')->references('id')->on('boutiques')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reapprovisionnements');
    }
};
