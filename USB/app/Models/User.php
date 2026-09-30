<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nombres',
        'codigo_institucional',
        'email',
        'foto_perfil',
        'role_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación con el rol (RF-14)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper para verificar roles en la aplicación
    public function hasRole($roleName)
    {
        return $this->role->nombre === $roleName;
    }
}
