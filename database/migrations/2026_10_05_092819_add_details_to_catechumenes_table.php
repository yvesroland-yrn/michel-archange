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
        Schema::table('catechumenes', function (Blueprint $table) {
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('profession')->nullable();
            $table->enum('situation', ['eleve', 'etudiant', 'travailleur'])->default('eleve');
            $table->string('classe_etude')->nullable();
            $table->string('telephone')->nullable();
            $table->string('telephone_parent')->nullable();
            $table->string('nom_urgence')->nullable();
            $table->string('contact_urgence')->nullable();
            $table->string('parrain')->nullable();
            $table->string('marraine')->nullable();
            $table->string('annee_cate')->nullable();
            $table->string('ceb')->nullable();
            $table->boolean('bapte')->default(false);
            $table->unsignedBigInteger('montant_a_payer')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catechumenes', function (Blueprint $table) {
            $table->dropColumn([
                'nom', 'prenoms', 'profession', 'situation', 'classe_etude',
                'telephone', 'telephone_parent', 'nom_urgence', 'contact_urgence',
                'parrain', 'marraine', 'annee_cate', 'ceb', 'bapte', 'montant_a_payer'
            ]);
        });
    }
};
