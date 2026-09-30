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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

       $user = Auth::user();
        $rol = $user->role->nombre ?? 'Estudiante'; // Si no tiene rol, por defecto será Estudiante

        // Si es Administrador, Rector o Coordinador va al dashboard general de gestión
        if (in_array($rol, ['Coordinador de Carrera', 'Rector', 'Administrador'])) {
            return redirect()->intended('/dashboard');
        }

        // Si es Estudiante, va a su vista exclusiva
        return redirect()->intended('/estudiante/dashboard');

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

