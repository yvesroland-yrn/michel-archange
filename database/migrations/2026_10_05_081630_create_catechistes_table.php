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
        Schema::create('catechistes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenoms');
            $table->string('telephone')->nullable();
            $table->enum('section', ['ENFANT', 'JEUNE', 'ADULTE'])->default('ENFANT');
            $table->enum('statut', ['actif', 'inactif'])->default('actif');
            $table->foreignId('fidele_id')->nullable()->constrained()->nullOnDelete();
            $table->text('observations')->nullable();
            $table->timestamps();
            $table->index(['nom', 'prenoms']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catechistes');
    }
};
