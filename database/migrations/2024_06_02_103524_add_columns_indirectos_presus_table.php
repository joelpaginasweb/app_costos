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
        Schema::table('presus', function (Blueprint $table) {
            
            $table->decimal('indirectos',12,4);
            $table->decimal('financiam',12,4);
            $table->decimal('utilidad',12,4);
            $table->decimal('cargos_adicion',12,4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presus', function (Blueprint $table) {
            //
        });
    }
};
