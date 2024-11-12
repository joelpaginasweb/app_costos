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
        Schema::create('conceptos_mano_obras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_categoria')
            ->references('id')
            ->on('mano_de_obra');

            $table->foreignId('id_tarjeta')
              ->references('id')
              ->on('tarjetas');           
            
            $table->decimal('cantidad',11,5);
            $table->decimal('importe',11,5);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos_mano_obras');
    }
};
