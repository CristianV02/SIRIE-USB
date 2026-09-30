<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Web - Sistema SIRIE (Universidad Simón Bolívar)
|--------------------------------------------------------------------------
*/

// Ruta principal: Redirige directamente al inicio de sesión (Login)
Route::get('/', function () {
    return view('auth.login');
});

// Rutas protegidas que requieren autenticación previa
Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth'])->group(function () {

        // Dashboard general (Administradores / Coordinadores)
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Dashboard exclusivo para Estudiantes
        Route::get('/estudiante/dashboard', function () {
            return view('estudiante.dashboard');
        })->name('estudiante.dashboard');

        // Módulos institucionales...
        Route::get('/solicitudes/crear', function () {
            return view('solicitudes.crear');
        });

        Route::get('/bandeja-gestion', function () {
            return view('bandeja.gestion');
        });

        Route::get('/perfil', function () {
            return view('perfil.index');
        });
    });

    // Rutas de administración de perfil de Laravel Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Carga de las rutas de autenticación por defecto de Laravel Breeze (Login, Register, Password Reset, etc.)
require __DIR__ . '/auth.php';
