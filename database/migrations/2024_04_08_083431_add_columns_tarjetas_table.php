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
        Schema::table('tarjetas', function (Blueprint $table) {
            //
            $table->decimal('indirectos',8,2);
            $table->decimal('financiam',8,2);
            $table->decimal('utilidad',8,2);
            $table->decimal('cargos_adicion',8,2);
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarjetas', function (Blueprint $table) {
            //
        });
    }
};
