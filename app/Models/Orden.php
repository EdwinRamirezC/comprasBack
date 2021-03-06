<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Orden extends Model
{
    use SoftDeletes;
    protected $table = 'ordenes';

    protected $fillable = [
        'id',
        'orden',
        'cliente',
        'nombre',
        'usuario_id',
        'articulos'
    ];
    protected $casts = [
        'articulos' => 'array',
    ];
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

}
