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
        //
        Schema::table('dashbos', function (Blueprint $table) {
          $table->renameColumn('porcind', 'porcent_indirecto');
          $table->renameColumn('porcfinan', 'porcent_financiam');
          $table->renameColumn('porcutil', 'porcent_utilidad');
          $table->renameColumn('porccostadd', 'porcent_costos_add');
          $table->renameColumn('porcsuma', 'porcent_suma');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('dashbos', function (Blueprint $table) {
          $table->renameColumn('porcent_indirecto','porcind');
      });
    }
};
