<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('baptemes', function (Blueprint $table) {
            $table->string('numero_carnet_bapteme')->nullable()->after('folio');
        });
    }

    public function down(): void
    {
        Schema::table('baptemes', function (Blueprint $table) {
            $table->dropColumn('numero_carnet_bapteme');
        });
    }
};
