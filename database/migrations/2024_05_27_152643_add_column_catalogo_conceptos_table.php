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
        Schema::table('catalogo_conceptos', function (Blueprint $table) {
            //
            $table->decimal('costo_directo',10,2);	
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
        Schema::table('catalogo_conceptos', function (Blueprint $table) {
            //
        });
    }
};
