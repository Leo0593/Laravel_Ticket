<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name', // Nuevo campo
        'phone', // Nuevo campo
        'email',
        'password',
        'role', // Nuevo campo
        'estado', // Nuevo campo
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Establecer el valor por defecto del role cuando no se proporciona uno.
     */
    protected $attributes = [
        'role' => 'USER',
    ];

    /**
     * Para cambiar el valor de 'estado' de un usuario.
     * Se asegura de que 'estado' tenga el valor por defecto de 1 (Activo).
     */
    public function setEstadoAttribute($value)
    {
        $this->attributes['estado'] = $value ?? 1;
    }
}
