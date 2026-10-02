<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intentions', function (Blueprint $table) {
            $table->enum('type', ['action_grace', 'repos_eternel', 'autre'])->default('autre')->after('intention');
            $table->date('date_tirage')->nullable()->after('date_messe');
            $table->string('jour_messe')->nullable()->after('date_tirage'); // samedi ou dimanche
            $table->string('numero_semaine')->nullable()->after('jour_messe'); // format: 2026-W40
        });
    }

    public function down(): void
    {
        Schema::table('intentions', function (Blueprint $table) {
            $table->dropColumn(['type', 'date_tirage', 'jour_messe', 'numero_semaine']);
        });
    }
};
