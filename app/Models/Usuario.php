<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'nombre',
        'apellido',
        'cedula',
        'tipo'
    ];

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }
}
