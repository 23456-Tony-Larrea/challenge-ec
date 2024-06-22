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
        Schema::create('poblacion_models', function (Blueprint $table) {
            $table->id();
            $table->string('CodProvincia');
            $table->string('Provincia');
            $table->string('CodMunicipio');
            $table->string('Municipio');
            $table->integer('Poblacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poblacion_models');
    }
};
