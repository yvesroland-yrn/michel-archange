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
        Schema::table('classes_cate', function (Blueprint $table) {
            $table->enum('section', ['ENFANT', 'JEUNE', 'ADULTE'])->default('ENFANT')->after('niveau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes_cate', function (Blueprint $table) {
            $table->dropColumn('section');
        });
    }
};
