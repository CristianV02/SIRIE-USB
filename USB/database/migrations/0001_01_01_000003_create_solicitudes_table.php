<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('codigo_radicado')->unique()->nullable(); // Módulo 3.5: Radicado único
            $table->enum('tipo', ['Queja', 'Idea', 'Ambas']); // Módulo 3.2
            $table->text('detalle_inconformidad')->nullable();
            $table->text('propuesta_mejora')->nullable();
            $table->string('asignatura')->nullable(); // Módulo 3.3
            $table->string('palabras_clave')->nullable(); // Módulo 3.3
            $table->string('codigo_institucional'); // Módulo 3.3
            $table->string('evidencia_path')->nullable(); // Módulo 3.4: Archivo de evidencia
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
};
