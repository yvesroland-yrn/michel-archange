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
        Schema::table('clerges', function (Blueprint $table) {
            $table->string('role')->default('curé')->change();
        });

        \DB::table('clerges')->where('role', 'diacre')->update(['role' => 'resident']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('clerges')->where('role', 'resident')->update(['role' => 'diacre']);

        Schema::table('clerges', function (Blueprint $table) {
            $table->string('role')->default('curé')->change();
        });
    }
};
