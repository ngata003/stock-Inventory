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
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->string('nom_boutique')->unique();
            $table->string('adresse')->nullable();
            $table->string('telephone')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('site_web')->nullable();
            $table->unsignedBigInteger('fk_createur');
            $table->string('logo')->nullable();

            $table->foreign('fk_createur')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
