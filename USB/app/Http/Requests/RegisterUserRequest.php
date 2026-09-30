<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo_institucional' => 'required|numeric|unique:users,codigo_institucional',
            // Validación estricta de dominio universitario
            'email' => ['required', 'email', 'ends_with:@unisimon.edu.co', 'unique:users,email'],
            'password' => 'required|min:8',
            // Validación de la foto: restringe formatos e impone un límite de seguridad
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // Max 10MB (RF-04)
            'role_id' => 'required|exists:roles,id'
        ];
    }

    public function messages()
    {
        return [
            'email.ends_with' => 'Debe utilizar un correo con dominio universitario válido.',
            'codigo_institucional.numeric' => 'El código debe ser estrictamente numérico.',
        ];
    }
}
