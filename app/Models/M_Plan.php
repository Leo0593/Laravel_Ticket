<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Plan extends Model
{
    protected $table = 'plans';  // Especifica la tabla si es necesario

    use HasFactory;

    protected $fillable = [
        'evento_id',
        'tipo',
        'precio',
        'descripcion',
        'Foto',
    ];

    public function evento()
    {
        return $this->belongsTo(M_Eventos::class, 'evento_id');
    }

    public function asientos()
    {
        return $this->hasMany(M_Asientos::class, 'plan_id'); 
    }

    public function asientosDisponibles()
    {
        return $this->hasMany(M_Asientos::class, 'plan_id')
            ->where('estado', 'disponible');
    }
    
}
