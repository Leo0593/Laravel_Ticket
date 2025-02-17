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
        Schema::create('asientos', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('local_id')->constrained('locales')->onDelete('cascade'); // Relación con la tabla 'Lugar'
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade'); // Relación con la tabla 'Evento'
            $table->foreignId('plan_id')->nullable()->constrained('plans')->onDelete('cascade'); // Relación con la tabla 'Plan'
            $table->enum('tipo', ['General', 'VIP'])->default('General'); // Tipo de asiento
            $table->integer('numero_asiento'); // Número del asiento
            $table->enum('estado', ['Disponible', 'Ocupado']); // Estado del asiento
            $table->boolean('visible')->default(true)->notNull(); // Campo visible con valor predeterminado 'true' y no nulo
            $table->timestamps(); // Timestamps: created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Deshace los cambios de la migración, eliminando la tabla
     */
    public function down(): void
    {
        Schema::dropIfExists('asientos');
    }
};