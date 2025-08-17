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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('fk_createur')->nullable();
            $table->unsignedBigInteger('fk_boutique')->nullable();
            $table->boolean('status_connexion')->default(0);

            $table->foreign('fk_createur')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fk_boutique')->references('id')->on('boutiques')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
