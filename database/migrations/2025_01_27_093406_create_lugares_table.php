<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->id(); // Auto-incremental primary key
            $table->string('Nombre', 255);
            $table->text('Descripcion')->nullable();
            $table->string('Direccion', 255);
            $table->string('Telefono', 20)->nullable();
            $table->integer('Aforo');
            $table->boolean('Tiene_Asientos')->default(0);
            $table->string('Foto')->nullable();  // Columna para la foto
            $table->boolean('visible')->default(true)->notNull(); // Campo visible con valor predeterminado 'true' y no nulo
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locales');
    }
};
