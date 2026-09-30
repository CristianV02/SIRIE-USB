<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('trazabilidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario que realiza la acción
            $table->string('estado'); // Registrada, En Revisión, Duplicada, En Proceso, Escalada, Resuelta
            $table->string('rol_responsable'); // Rol del usuario en el momento del cambio
            $table->text('observaciones')->nullable();
            $table->timestamps(); // Incluye implícitamente fecha y hora cronológica
        });
    }

    public function down()
    {
        Schema::dropIfExists('trazabilidad');
    }
};
