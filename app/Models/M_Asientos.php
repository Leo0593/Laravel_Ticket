<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Asientos extends Model
{
    protected $table = 'asientos'; 

    use HasFactory;

    protected $fillable = [
        'local_id',
        'evento_id',
        'plan_id',
        'tipo',
        'numero_asiento',
        'estado',
    ];

    protected $casts = [
        'numero_asiento' => 'integer', // Asegura que siempre sea un entero
    ];

    // Relación con el modelo de Locales
    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    // Relación con el modelo de Eventos
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    // Relación con el modelo de Planes
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
