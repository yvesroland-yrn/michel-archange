<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sacrements', function (Blueprint $table) {
            $table->string('numero_registre_mariage')->nullable()->after('observations');
        });
    }

    public function down(): void
    {
        Schema::table('sacrements', function (Blueprint $table) {
            $table->dropColumn('numero_registre_mariage');
        });
    }
};
