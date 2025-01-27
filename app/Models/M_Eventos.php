<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Eventos extends Model
{
    protected $table = 'eventos';  // Especifica la tabla si es necesario

    use HasFactory;

    protected $fillable = [
        'user_id',
        'local_id',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'fecha_evento',
        'aforo_evento',
        'estado',
        'Foto',
    ];
}
