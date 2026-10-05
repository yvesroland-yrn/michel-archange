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
        Schema::create('catechiste_classe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('catechiste_id')->constrained()->onDelete('cascade');
            $table->foreignId('classe_cate_id')->constrained('classes_cate')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['catechiste_id', 'classe_cate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catechiste_classe');
    }
};
