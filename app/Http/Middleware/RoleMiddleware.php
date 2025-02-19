<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login'); // Redirigir si no está autenticado
        }

        // Obtener el rol del usuario autenticado (suponiendo que en la tabla 'users' hay un campo 'role')
        $userRole = Auth::user()->role;

        // Verificar si el usuario tiene uno de los roles permitidos
        if (!in_array($userRole, $roles)) {
            abort(403, 'Acceso denegado, Debes subir de Rol'); // Retorna error 403 si no tiene permiso
        }

        return $next($request);
    }
}
