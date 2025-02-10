<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Tickets extends Model
{
    protected $table = 'tickets';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'asiento_id',
        'plan_id',
        'evento_id',
        'pagado',
        'fecha_pago',
        'qr',
        'qr_valido',
    ];

    protected $casts = [
        'pagado' => 'boolean',
        'fecha_pago' => 'datetime',
        'qr_valido' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asiento()
    {
        return $this->belongsTo(M_Asientos::class);
    }

    public function plan()
    {
        return $this->belongsTo(M_Plan::class, 'plan_id');
    }

    public function evento()
    {
        return $this->belongsTo(M_Eventos::class, 'evento_id');
    }
}