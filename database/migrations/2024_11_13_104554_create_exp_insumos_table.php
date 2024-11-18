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
        Schema::create('exp_insumos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_grupo')
            ->references('id')
            ->on('grupos');

            $table->foreignId('id_presup')
            ->references('id')
            ->on('presupuestos');        

            $table->foreignId('id_tarjeta')
            ->references('id')
            ->on('tarjetas');

            $table->foreignId('id_material')
            ->references('id')
            ->on('materiales');

            $table->foreignId('id_categoria')
            ->references('id')
            ->on('mano_de_obra');

            $table->foreignId('id_equipo')
            ->references('id')
            ->on('herramientas_equipos');

            $table->decimal('cantidad',11,4);
            $table->decimal('monto',11,4);
            $table->string('tipo')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exp_insumos');
    }
};
