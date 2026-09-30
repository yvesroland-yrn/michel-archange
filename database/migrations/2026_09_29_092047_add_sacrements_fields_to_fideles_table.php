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
        Schema::table('fideles', function (Blueprint $table) {
            $table->boolean('baptise')->default(false);
            $table->boolean('confirme')->default(false);
            $table->boolean('marie')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fideles', function (Blueprint $table) {
            $table->dropColumn(['baptise', 'confirme', 'marie']);
        });
    }
};
