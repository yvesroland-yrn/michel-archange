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
        Schema::create('budget_annuels', function (Blueprint $table) {
            $table->id();
            $table->string('annee')->unique(); // Format: 2026-2027
            $table->decimal('recettes_totales', 15, 2)->default(0);
            $table->decimal('depenses_totales', 15, 2)->default(0);
            $table->decimal('solde', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('lignes_budget', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_annuel_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->decimal('montant', 15, 2);
            $table->string('type')->default('depense'); // depense ou recette
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_annuels');
    }
};
