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
        Schema::create('conceptos_cuadrillas', function (Blueprint $table) {
            $table->id();
            $table->integer('id_categoria');
            $table->text('categoria');
            $table->string('unidad');
            $table->decimal('cantidad',11,5);
            $table->decimal('salario',11,2);
            $table->decimal('importe',12,4);
            $table->string('id_cuadrilla');   
            $table->string('cuadrilla_origen');
            $table->string('tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos_cuadrillas');
    }
};
