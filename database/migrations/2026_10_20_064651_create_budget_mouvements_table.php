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
        Schema::create('budget_mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_ligne_id')->constrained('budget_lignes')->onDelete('cascade');
            $table->date('date_operation');
            $table->unsignedBigInteger('montant');
            $table->string('description');
            $table->string('reference')->nullable();
            $table->string('justificatif')->nullable();
            $table->string('beneficiaire')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budget_mouvements');
    }
};
