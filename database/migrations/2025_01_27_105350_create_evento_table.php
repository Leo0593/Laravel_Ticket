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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('local_id')->constrained('locales')->onDelete('cascade'); // Relación con la tabla 'Lugar'
            $table->string('nombre'); // Nombre del evento
            $table->text('descripcion')->nullable(); // Descripción del evento
            $table->dateTime('fecha_inicio'); // Fecha de inicio
            $table->dateTime('fecha_fin'); // Fecha de fin
            $table->dateTime('fecha_evento'); // Fecha del evento
            $table->integer('aforo_evento'); // Aforo del evento
            $table->enum('estado', ['ACTIVO', 'CANCELADO', 'FINALIZADO']); // Estado del evento
            $table->string('Foto')->nullable();
            $table->timestamps(); // Timestamps: created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Deshace los cambios de la migración, eliminando la tabla
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};