<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('cebs', function (Blueprint $t) {
            $t->id(); $t->string('nom')->unique(); $t->string('responsable')->nullable(); $t->timestamps();
        });
        Schema::create('fideles', function (Blueprint $t) {
            $t->id(); $t->string('nom'); $t->string('prenoms'); $t->enum('sexe', ['M', 'F']);
            $t->date('date_naissance')->nullable(); $t->string('lieu_naissance')->nullable();
            $t->string('telephone')->nullable(); $t->string('email')->nullable(); $t->string('profession')->nullable();
            $t->string('quartier')->nullable(); $t->string('situation_matrimoniale')->nullable();
            $t->foreignId('ceb_id')->nullable()->constrained()->nullOnDelete();
            $t->enum('statut', ['actif', 'transfere', 'decede'])->default('actif');
            $t->timestamps(); $t->index(['nom', 'prenoms']);
        });
        Schema::create('baptemes', function (Blueprint $t) {
            $t->id(); $t->foreignId('fidele_id')->unique()->constrained()->cascadeOnDelete();
            $t->string('numero_acte')->unique(); $t->date('date_bapteme'); $t->string('lieu')->nullable();
            $t->string('ministre'); $t->string('parrain')->nullable(); $t->string('marraine')->nullable();
            $t->string('pere')->nullable(); $t->string('mere')->nullable();
            $t->string('livre')->nullable(); $t->string('folio')->nullable(); $t->timestamps();
        });
        Schema::create('sacrements', function (Blueprint $t) {
            $t->id(); $t->string('type'); $t->foreignId('fidele_id')->constrained()->cascadeOnDelete();
            $t->foreignId('conjoint_id')->nullable()->constrained('fideles')->nullOnDelete();
            $t->date('date_celebration'); $t->string('lieu')->nullable(); $t->string('ministre')->nullable();
            $t->string('temoin1')->nullable(); $t->string('temoin2')->nullable();
            $t->string('numero_acte')->unique(); $t->text('observations')->nullable(); $t->timestamps();
            $t->index(['type', 'fidele_id']);
        });
        Schema::create('mouvements', function (Blueprint $t) {
            $t->id(); $t->string('nom')->unique(); $t->string('responsable')->nullable();
            $t->date('date_creation')->nullable(); $t->text('description')->nullable(); $t->timestamps();
        });
        Schema::create('fidele_mouvement', function (Blueprint $t) {
            $t->id(); $t->foreignId('fidele_id')->constrained()->cascadeOnDelete();
            $t->foreignId('mouvement_id')->constrained()->cascadeOnDelete();
            $t->string('fonction')->default('Membre'); $t->timestamps(); $t->unique(['fidele_id', 'mouvement_id']);
        });
        Schema::create('classes_cate', function (Blueprint $t) {
            $t->id(); $t->string('annee'); $t->string('niveau'); $t->string('catechiste')->nullable(); $t->timestamps();
        });
        Schema::create('catechumenes', function (Blueprint $t) {
            $t->id(); $t->foreignId('fidele_id')->constrained()->cascadeOnDelete();
            $t->foreignId('classe_cate_id')->constrained('classes_cate')->cascadeOnDelete();
            $t->string('statut')->default('inscrit'); $t->string('observation')->nullable(); $t->timestamps();
            $t->unique(['fidele_id', 'classe_cate_id']);
        });
        Schema::create('evenements', function (Blueprint $t) {
            $t->id(); $t->string('titre'); $t->string('type'); $t->dateTime('date_heure');
            $t->string('lieu')->nullable(); $t->string('celebrant')->nullable(); $t->text('description')->nullable();
            $t->timestamps(); $t->index('date_heure');
        });
        Schema::create('intentions', function (Blueprint $t) {
            $t->id(); $t->string('demandeur'); $t->string('telephone')->nullable(); $t->text('intention');
            $t->unsignedBigInteger('offrande')->default(0); $t->date('date_messe');
            $t->foreignId('evenement_id')->nullable()->constrained()->nullOnDelete();
            $t->string('statut')->default('recue'); $t->string('recu_numero')->unique();
            $t->foreignId('user_id')->constrained(); $t->timestamps();
        });
        Schema::create('annonces', function (Blueprint $t) {
            $t->id(); $t->string('titre'); $t->text('contenu'); $t->date('publie_le'); $t->date('expire_le')->nullable(); $t->timestamps();
        });
        Schema::create('recettes', function (Blueprint $t) {
            $t->id(); $t->date('date'); $t->string('type'); $t->unsignedBigInteger('montant');
            $t->foreignId('fidele_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('ceb_id')->nullable()->constrained()->nullOnDelete();
            $t->string('recu_numero')->unique(); $t->string('note')->nullable();
            $t->foreignId('user_id')->constrained(); $t->timestamps();
        });
        Schema::create('depenses', function (Blueprint $t) {
            $t->id(); $t->date('date'); $t->string('categorie'); $t->string('libelle');
            $t->unsignedBigInteger('montant'); $t->foreignId('user_id')->constrained(); $t->timestamps();
        });
    }
    public function down(): void {
        foreach (['depenses','recettes','annonces','intentions','evenements','catechumenes','classes_cate','fidele_mouvement','mouvements','sacrements','baptemes','fideles','cebs'] as $x) Schema::dropIfExists($x);
    }
};
