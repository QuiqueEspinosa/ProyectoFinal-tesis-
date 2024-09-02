<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_mesa')->unique();
            $table->string('titulo');
            $table->text('nota')->nullable();
            $table->string('tipo_mesa');
            $table->integer('posicion'); // Posición dentro de la lista
            $table->enum('lista', ['izquierda', 'derecha']); // Lista a la que pertenece la mesa
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
