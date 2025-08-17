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
        Schema::table('ventes', function (Blueprint $table) {
            //
            $table->string('montant_paye')->nullable()->change();
            $table->string('montant_remboursé')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventes', function (Blueprint $table) {
            //
            $table->string('montant_paye')->nullable(false)->change();
            $table->string('montant_remboursé')->nullable(false)->change();
        });
    }
};
