<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager; // Requiere composer require intervention/image
use Intervention\Image\Drivers\Gd\Driver;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        $fotoPath = null;

        if ($request->hasFile('foto_perfil')) {
            $image = $request->file('foto_perfil');
            $filename = $validated['codigo_institucional'] . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Cumplimiento RNF-03: Redimensionar y comprimir para mantener peso < 80KB
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image->getRealPath());

            // scale() reemplaza a resize() y mantiene la proporción automáticamente
            $img->scale(width: 300, height: 300);

            // toJpeg() reemplaza a encode()
            Storage::disk('public')->put('avatares/' . $filename, (string) $img->toJpeg(75));
            $fotoPath = 'avatares/' . $filename;
        }

        $user = User::create([
            'nombres' => $validated['nombres'] ?? '',
            'codigo_institucional' => $validated['codigo_institucional'],
            'email' => $validated['email'],
            'foto_perfil' => $fotoPath,
            'role_id' => $validated['role_id'],
            'password' => Hash::make($validated['password']), // Cifrado seguro
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user
        ], 201);
    }
}
