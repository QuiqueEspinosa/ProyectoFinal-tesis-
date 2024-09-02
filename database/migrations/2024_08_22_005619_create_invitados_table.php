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
            $table->integer('edad');
            $table->enum('sexo', ['M', 'F', 'Otro']);
            $table->string('mesa');
            $table->string('menu');
            $table->string('lista');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->string('direccion');
            $table->boolean('invitacion');
            $table->integer('confirmacion');
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
