<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    // Relación inversa: Un rol puede pertenecer a varios usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
