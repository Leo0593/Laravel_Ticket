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
        Schema::create('plans', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade'); // Relación con la tabla 'eventos'
            $table->enum('tipo', ['General', 'VIP']); // Tipo de plan
            $table->decimal('precio', 10, 2); // Precio con hasta 8 dígitos a la izquierda del punto decimal y 2 dígitos a la derecha
            $table->text('descripcion')->nullable(); // Descripción del plan (opcional)
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
        Schema::dropIfExists('plans');
    }
};
