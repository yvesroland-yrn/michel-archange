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
            $table->dropColumn('catechiste');
            $table->foreignId('catechiste_id')->nullable()->constrained('catechistes')->nullOnDelete()->after('section');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes_cate', function (Blueprint $table) {
            $table->dropForeign(['catechiste_id']);
            $table->dropColumn('catechiste_id');
            $table->string('catechiste')->nullable()->after('section');
        });
    }
};
