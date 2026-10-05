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
        Schema::create('annees_catechetiques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique(); // ex: 2026-2027
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('statut', ['actif', 'cloture'])->default('actif');
            $table->text('observations')->nullable();
            $table->timestamps();
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annees_catechetiques');
    }
};
