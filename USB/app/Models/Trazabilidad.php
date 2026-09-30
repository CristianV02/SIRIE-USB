<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trazabilidad extends Model
{
    protected $table = 'trazabilidad';

    protected $fillable = [
        'solicitud_id',
        'user_id',
        'estado',
        'rol_responsable',
        'observaciones',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
