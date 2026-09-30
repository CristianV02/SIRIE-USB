<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'user_id',
        'tipo',
        'detalle_inconformidad',
        'propuesta_mejora',
        'asignatura',
        'palabras_clave',
        'codigo_institucional',
        'evidencia_path', // <-- Agregado para el módulo 3.4
        'codigo_radicado', // <-- Agregado para el módulo 3.5
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function trazabilidades()
    {
        return $this->hasMany(Trazabilidad::class)->orderBy('created_at', 'asc');
    }
}
