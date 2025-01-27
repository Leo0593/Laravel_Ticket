<?php

// Create tables

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Este método contiene las instrucciones para crear las tablas y sus columnas cuando la migración se ejecuta.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('name', 255); // Nombre del usuario
            $table->string('last_name', 255); // Apellido del usuario (corrección: "lastaname" -> "lastname")
            $table->string('phone', 20)->nullable(); // Teléfono con un máximo de 20 caracteres, opcional
            $table->string('email')->unique(); // Correo electrónico, único
            $table->timestamp('email_verified_at')->nullable(); // Fecha y hora de verificación del correo
            $table->enum('role', ['GESTOR', 'ADMIN', 'USER'])->default('USER'); // Rol del usuario, con valor por defecto 'USER'
            $table->boolean('estado')->default(1); // Estado: 1 (Activo), 0 (Inactivo)
            $table->string('password'); // Contraseña
            $table->rememberToken(); // Token para recordar la sesión
            $table->timestamps(); // Timestamps: created_at y updated_at
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Correo, clave primaria
            $table->string('token'); // Token de restablecimiento
            $table->timestamp('created_at')->nullable(); // Fecha de creación
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID de la sesión
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); // Relación con `users`
            $table->string('ip_address', 45)->nullable(); // Dirección IP
            $table->text('user_agent')->nullable(); // Agente de usuario
            $table->longText('payload'); // Datos de la sesión
            $table->integer('last_activity')->index(); // Última actividad
        });
    }

    /**
     * Reverse the migrations.
     * Deshace los cambios de la migración, es decir, elimina las tablas creadas
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
