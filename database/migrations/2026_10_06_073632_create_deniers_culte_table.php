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
        Schema::create('deniers_culte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fidele_id')->nullable()->constrained()->nullOnDelete();
            $table->string('donateur_nom')->nullable();
            $table->string('numero_carnet_bapteme')->nullable();
            $table->date('date_paiement');
            $table->unsignedBigInteger('montant');
            $table->enum('periode', ['mensuelle', 'trimestrielle', 'annuelle', 'ponctuelle'])->default('mensuelle');
            $table->text('note')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
            
            $table->index(['date_paiement', 'fidele_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deniers_culte');
    }
};
