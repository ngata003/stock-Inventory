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
        Schema::table('produits', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('fk_categorie')->nullable();
            $table->unsignedBigInteger('fk_fournisseur')->nullable();


            $table->foreign('fk_categorie')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_fournisseur')->references('id')->on('fournisseurs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            //
        });
    }
};
