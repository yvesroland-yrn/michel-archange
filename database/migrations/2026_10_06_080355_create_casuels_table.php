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
        Schema::create('casuels', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['bapteme', 'confirmation', 'mariage', 'deces']);
            $table->foreignId('fidele_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('profession')->nullable();
            $table->string('numero')->nullable();
            $table->unsignedBigInteger('montant');
            $table->date('date_paiement');
            $table->text('note')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            
            $table->index(['type', 'date_paiement']);
            $table->index('fidele_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casuels');
    }
};
