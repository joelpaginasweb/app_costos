<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();            
            $table->string('razon_social');
            $table->string('nombre');

            $table->foreignId('id_estado')
                ->references('id')
                ->on('estados');
                
            $table->foreignId('id_ciudad')
                ->references('id')
                ->on('ciudades');
                
            $table->string('calle');
            $table->string('colonia');
            $table->string('cp');
            $table->string('no_exterior');
            $table->string('referencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
