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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('categorie');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('fk_createur');
            $table->unsignedBigInteger('fk_boutique');

            $table->foreign('fk_createur')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_boutique')->references('id')->on('boutiques')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['categorie', 'fk_boutique']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
