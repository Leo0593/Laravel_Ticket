<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Locales extends Model
{
    protected $table = 'locales';  // Especifica la tabla si es necesario

    use HasFactory;

    // Especificamos los campos que pueden ser asignados masivamente
    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Direccion',
        'Telefono',
        'Aforo',
        'Tiene_Asientos',
        'Foto',
    ];

    public function eventos()
    {
        return $this->hasMany(M_Eventos::class, 'local_id');
    }
}