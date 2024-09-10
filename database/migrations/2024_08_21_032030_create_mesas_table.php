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
            $table->integer('numero_mesa')->unique()->nullable(); // La mesa principal no tendrá número.
            $table->string('titulo');
            $table->text('nota')->nullable();
            $table->string('tipo_mesa'); // 'Principal' o 'Común'.
            $table->integer('posicion'); // Posición en el orden.
            $table->integer('x')->default(0); // Posición X.
            $table->integer('y')->default(0); // Posición Y.
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
