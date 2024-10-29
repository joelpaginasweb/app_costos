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
            $table->string('tipo');  
            $table->text('insumo'); 
            $table->string('unidad');
            $table->decimal('cantidad',11,4);
            $table->decimal('precio_unitario',11,4);
            $table->decimal('monto',11,4);
            $table->integer('id_presup'); 
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
