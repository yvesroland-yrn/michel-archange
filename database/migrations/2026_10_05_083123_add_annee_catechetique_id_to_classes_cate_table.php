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
            $table->dropColumn('annee');
            $table->foreignId('annee_catechetique_id')->nullable()->constrained('annees_catechetiques')->nullOnDelete()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes_cate', function (Blueprint $table) {
            $table->dropForeign(['annee_catechetique_id']);
            $table->dropColumn('annee_catechetique_id');
            $table->string('annee')->after('id');
        });
    }
};
