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
            $table->string('foto')->nullable(); // Campo para la foto del invitado
            $table->string('nombre');
            $table->string('apellido');
            $table->enum('edad', ['bebe', 'niño', 'adulto']);
            $table->enum('sexo', ['M', 'F', 'otro']);
            $table->enum('menu', ['Adulto', 'Infantil', 'Vegetariano', 'Dietetico']);
            $table->integer('cant_acompanantes')->nullable();
            $table->enum('confirmacion', ['en espera', 'aceptado', 'rechazado'])->default('en espera');
            $table->enum('especial', ['si', 'no'])->default('no');
            $table->string('codigo')->unique();
            $table->foreignId('mesa_id')->nullable()->constrained('mesas')->onDelete('set null'); // Relación con la tabla mesas.
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
