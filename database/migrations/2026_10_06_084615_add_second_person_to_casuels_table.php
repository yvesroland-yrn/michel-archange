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
        Schema::table('casuels', function (Blueprint $table) {
            $table->foreignId('fidele_id_2')->nullable()->after('fidele_id')->constrained('fideles')->nullOnDelete();
            $table->string('nom_2')->nullable()->after('prenoms');
            $table->string('prenoms_2')->nullable()->after('nom_2');
            $table->date('date_naissance_2')->nullable()->after('date_naissance');
            $table->string('profession_2')->nullable()->after('profession');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('casuels', function (Blueprint $table) {
            $table->dropForeign(['fidele_id_2']);
            $table->dropColumn(['fidele_id_2', 'nom_2', 'prenoms_2', 'date_naissance_2', 'profession_2']);
        });
    }
};
