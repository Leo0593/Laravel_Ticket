<?php

// php artisan make:migration create_ticket_table

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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con la tabla 'Usuarios'
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade'); // Relación con la tabla 'Evento'
            $table->foreignId('asiento_id')->constrained('asientos')->onDelete('cascade'); // Relación con la tabla 'Asiento'
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade'); // Relación con la tabla 'Plan'
            $table->boolean('pagado'); // Indica si el ticket ha sido pagado
            $table->timestamp('fecha_pago')->nullable(); // Fecha de pago (opcional)
            $table->string('qr')->nullable()->unique(); // Código QR único para el ticket y permite valores NULL
            $table->boolean('qr_valido'); // Indica si el QR es válido
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
        Schema::dropIfExists('tickets');
    }
};
