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
        Schema::create('porcent_indirectos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_presup')
            ->references('id')
            ->on('presupuestos');        

            // $table->foreignId('id_tarjeta')
            // ->references('id')
            // ->on('tarjetas');   

            $table->smallInteger('porcent_indirecto');
            $table->smallInteger('porcent_financiam');
            $table->smallInteger('porcent_utilidad');
            $table->smallInteger('porcent_costos_add');
            $table->smallInteger('porcent_suma');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porcent_indirectos');
    }
};
