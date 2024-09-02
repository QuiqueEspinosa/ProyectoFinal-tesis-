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
        Schema::create('config', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_evento')->nullable();
            $table->string('clase_evento')->nullable();
            $table->string('horario')->nullable();
            $table->string('salon')->nullable();
            $table->integer('cant_mesas')->nullable();
            $table->integer('cant_sillas')->nullable();
            $table->integer('cant_total_de_invitados')->nullable();
            $table->decimal('precio_adulto', 8, 2)->nullable();
            $table->decimal('precio_menor', 8, 2)->nullable();
            $table->integer('cant_mesa_principal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config');
    }
};
