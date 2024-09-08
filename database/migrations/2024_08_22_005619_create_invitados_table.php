<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('invitados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->enum('edad', ['bebe', 'niño', 'adulto']); // Campo edad simplificado
            $table->enum('sexo', ['M', 'F', 'otro']);
            $table->enum('menu', ['Adulto', 'Infantil', 'Vegetariano', 'Dietetico']); // Menú por categorías
            $table->integer('cant_acompanantes')->nullable(); // Campo de acompañantes que puede ser null
            $table->enum('confirmacion', ['en espera', 'aceptado', 'rechazado'])->default('en espera'); // Confirmación con estado por defecto
            $table->string('codigo')->unique(); // Campo para el código único
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitados');
    }
};
