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
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_grupo')
              ->references('id')
              ->on('grupos');

            $table->string('material');

            $table->foreignId('id_unidad')
              ->references('id')
              ->on('unidades');

            $table->decimal('precio_unitario', 10, 2);

            $table->foreignId('id_proveedor')
              ->references('id')
              ->on('proveedores');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
