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
        Schema::table('lignes_budget', function (Blueprint $table) {
            $table->dropForeign(['budget_annuel_id']);
        });

        Schema::table('budget_annuels', function (Blueprint $table) {
            $table->string('annee')->change();
        });

        Schema::table('lignes_budget', function (Blueprint $table) {
            $table->foreign('budget_annuel_id')->references('id')->on('budget_annuels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lignes_budget', function (Blueprint $table) {
            $table->dropForeign(['budget_annuel_id']);
        });

        Schema::table('budget_annuels', function (Blueprint $table) {
            $table->integer('annee')->change();
        });

        Schema::table('lignes_budget', function (Blueprint $table) {
            $table->foreign('budget_annuel_id')->references('id')->on('budget_annuels')->onDelete('cascade');
        });
    }
};
