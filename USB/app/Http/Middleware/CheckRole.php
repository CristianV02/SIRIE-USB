<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $userRole = $user->role->nombre ?? '';

        if (!in_array($userRole, $roles)) {
            abort(403, 'Acceso denegado. No cuenta con los permisos necesarios.');
        }

        return $next($request);
    }
}
