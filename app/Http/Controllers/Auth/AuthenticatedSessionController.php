<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Intentar autenticar al usuario con las credenciales proporcionadas
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Obtiene el usuario autenticado

            // Verificar si el estado del usuario es 1 (activo)
            if ($user->estado !== 1) {
                // Si no está activo, cerrar la sesión y redirigir al login con un mensaje de error
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tu cuenta está inactiva. Contacta con un administrador.',
                ]);
            }

            // Si el estado es activo, regenerar la sesión
            $request->session()->regenerate();

            // Redirigir al dashboard o la página solicitada
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Si las credenciales no son correctas
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
