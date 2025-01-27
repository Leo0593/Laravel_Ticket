<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Locales extends Model
{
    protected $table = 'locales';  // Especifica la tabla si es necesario

    Use HasFactory;

    // Especificamos los campos que pueden ser asignados masivamente
    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Direccion',
        'Telefono',
        'Aforo',
        'Tiene_Asientos',
    ];
}