<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Trazabilidad;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificacionPqrMail;
use Barryvdh\DomPDF\Facade\Pdf;

class PqrController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:Queja,Idea,Ambas',
            'codigo_institucional' => 'required|string',
            'asignatura' => 'nullable|string',
            'palabras_clave' => 'nullable|string',
            'detalle_inconformidad' => 'nullable|string',
            'propuesta_mejora' => 'nullable|string',
            // Módulo 3.4: Validación de archivos MIME (pdf, jpg, jpeg, png) y tamaño máximo acumulado (10MB = 10240 KB)
            'evidencia' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Obtenemos el usuario autenticado y su rol de forma segura
        $user = Auth::user();
        $rolNombre = 'Estudiante';
        if ($user && $user->role) {
            $rolNombre = $user->role->nombre ?? 'Estudiante';
        }

        // Módulo 3.3: Prevención de duplicados en los últimos 30 días
        $duplicada = Solicitud::where('codigo_institucional', $request->codigo_institucional)
            ->where('asignatura', $request->asignatura)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->first();

        if ($duplicada) {
            return response()->json([
                'status' => 'duplicado',
                'message' => 'Se ha encontrado una solicitud similar activa en los últimos 30 días.',
                'radicado_existente_id' => $duplicada->id
            ], 422);
        }

        // Módulo 3.4: Procesamiento y almacenamiento seguro de la evidencia
        $evidenciaPath = null;
        if ($request->hasFile('evidencia')) {
            $file = $request->file('evidencia');
            $filename = 'evidencia_' . time() . '.' . $file->getClientOriginalExtension();
            // Almacena de forma segura en el disco público dentro de la carpeta 'evidencias'
            $evidenciaPath = $file->storeAs('evidencias', $filename, 'public');
        }

        // Módulo 3.2: Registro según la tipología seleccionada
        $solicitud = Solicitud::create([
            'user_id' => $user ? $user->id : null,
            'tipo' => $request->tipo,
            'detalle_inconformidad' => $request->tipo !== 'Idea' ? $request->detalle_inconformidad : null,
            'propuesta_mejora' => $request->tipo !== 'Queja' ? $request->propuesta_mejora : null,
            'asignatura' => $request->asignatura,
            'palabras_clave' => $request->palabras_clave,
            'codigo_institucional' => $request->codigo_institucional,
            'evidencia_path' => $evidenciaPath,
        ]);

        // Módulo 3.5: Generación del código de radicado único e irrepetible (Ej: QI-2026-00389)
        $prefijo = 'QI'; // Prefijo general para Quejas e Ideas
        $anio = Carbon::now()->year;
        $consecutivo = str_pad($solicitud->id, 5, '0', STR_PAD_LEFT);
        $codigoRadicado = "{$prefijo}-{$anio}-{$consecutivo}";

        // Actualizamos la solicitud con su código de radicado generado
        $solicitud->update([
            'codigo_radicado' => $codigoRadicado
        ]);

        // Módulo 3.6: Registro cronológico inicial en la Trazabilidad
        Trazabilidad::create([
            'solicitud_id' => $solicitud->id,
            'user_id' => $user ? $user->id : null,
            'estado' => 'Registrada',
            'rol_responsable' => $rolNombre,
            'observaciones' => 'Solicitud ingresada y radicada exitosamente en el sistema.',
        ]);

        // Módulo 3.9: Envío de correo de confirmación de registro (RF-07)
        if ($user && $user->email) {
            Mail::to($user->email)->send(new NotificacionPqrMail([
                'asunto' => 'Confirmación de Registro - Radicado ' . $codigoRadicado,
                'mensaje' => 'Su solicitud ha sido registrada e ingresada al sistema exitosamente.',
                'codigo_radicado' => $codigoRadicado
            ]));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Solicitud registrada y radicada con trazabilidad inicial.',
            'codigo_radicado' => $codigoRadicado,
            'data' => $solicitud->load('trazabilidades')
        ], 201);
    }

    // Módulo 3.6: Método para actualizar el estado y registrar cambios en la línea de tiempo
    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Registrada,En Revisión,Duplicada,En Proceso,Escalada,Resuelta',
            'observaciones' => 'nullable|string',
        ]);

        $solicitud = Solicitud::findOrFail($id);
        $user = Auth::user();

        $rolNombre = 'Administrador';
        if ($user && $user->role) {
            $rolNombre = $user->role->nombre ?? 'Administrador';
        }

        Trazabilidad::create([
            'solicitud_id' => $solicitud->id,
            'user_id' => $user ? $user->id : null,
            'estado' => $request->estado,
            'rol_responsable' => $rolNombre,
            'observaciones' => $request->observaciones ?? 'Cambio de estado en el flujo del trámite.',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Trazabilidad actualizada correctamente.',
            'historial' => $solicitud->trazabilidades()->get()
        ], 200);
    }
    // Módulo 3.7: Bandeja de gestión administrativa con filtros y fotografía del usuario
    public function index(Request $request)
    {
        $query = Solicitud::with(['user.role', 'trazabilidades']);

        // Filtro por Código institucional
        if ($request->filled('codigo_institucional')) {
            $query->where('codigo_institucional', 'like', '%' . $request->codigo_institucional . '%');
        }

        // Filtro por Correo del usuario asociado
        if ($request->filled('correo')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->correo . '%');
            });
        }

        // Filtro por Tipo de solicitud (Queja, Idea, Ambas)
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por Estado (basado en la última trazabilidad registrada)
        if ($request->filled('estado')) {
            $query->whereHas('trazabilidades', function ($q) use ($request) {
                $q->where('estado', $request->estado);
            });
        }

        $solicitudes = $query->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $solicitudes
        ], 200);
    }
    // Módulo 3.8: Escalamiento de casos hacia Rectoría
    public function escalarCaso(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string', // Motivo por el cual se escala
        ]);

        $solicitud = Solicitud::findOrFail($id);
        $user = Auth::user();
        $rolNombre = $user->role->nombre ?? 'Coordinador de Carrera';

        // Registramos el cambio de estado a 'Escalada' en la trazabilidad
        Trazabilidad::create([
            'solicitud_id' => $solicitud->id,
            'user_id' => $user->id,
            'estado' => 'Escalada',
            'rol_responsable' => $rolNombre,
            'observaciones' => 'Caso escalado a Rectoría: ' . $request->observaciones,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'El caso ha sido escalado a Rectoría exitosamente.',
            'historial_trazabilidad' => $solicitud->trazabilidades()->get()
        ], 200);
    }

    // Módulo 3.8: Solicitar información, aclaraciones o descargos
    public function solicitarAclaracion(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string', // Detalle de la información o descargos requeridos
        ]);

        $solicitud = Solicitud::findOrFail($id);
        $user = Auth::user();
        $rolNombre = $user->role->nombre ?? 'Directivo';

        // Registramos un estado de revisión o aclaración con las observaciones pertinentes
        Trazabilidad::create([
            'solicitud_id' => $solicitud->id,
            'user_id' => $user->id,
            'estado' => 'En Revisión',
            'rol_responsable' => $rolNombre,
            'observaciones' => 'Solicitud de información/descargos: ' . $request->observaciones,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Se ha solicitado información o aclaraciones al peticionario.',
            'historial_trazabilidad' => $solicitud->trazabilidades()->get()
        ], 200);
    }
    // Módulo 3.10: Generación de oficio o respuesta final en formato PDF al cerrar un caso


    public function generarOficioCierre(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string',
        ]);

        $solicitud = Solicitud::with('user.role')->findOrFail($id);
        $user = Auth::user();
        $rolNombre = $user->role->nombre ?? 'Administrador';

        // Registramos el cambio de estado a 'Resuelta' en la trazabilidad
        Trazabilidad::create([
            'solicitud_id' => $solicitud->id,
            'user_id' => $user->id,
            'estado' => 'Resuelta',
            'rol_responsable' => $rolNombre,
            'observaciones' => 'Caso cerrado. Oficio generado: ' . $request->observaciones,
        ]);

        // Generamos el PDF utilizando la plantilla Blade
        $pdf = Pdf::loadView('emails.oficio_respuesta', [
            'solicitud' => $solicitud,
            'observaciones' => $request->observaciones
        ]);

        // Retorna la descarga directa del archivo PDF formal
        return $pdf->download('Oficio_Resolucion_' . $solicitud->codigo_radicado . '.pdf');
    }
    /**
 * Módulo 3.11: Módulo de auditoría para consultar el registro histórico de acciones sobre expedientes.
 */
public function auditoriaGeneral(Request $request)
{
    // Consultamos la trazabilidad completa ordenada cronológicamente con su solicitud y usuario responsable
    $query = Trazabilidad::with(['solicitud', 'user.role']);

    // Filtro opcional por tipo de estado o acción
    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    // Filtro opcional por rol responsable
    if ($request->filled('rol_responsable')) {
        $query->where('rol_responsable', 'like', '%' . $request->rol_responsable . '%');
    }

    $auditorias = $query->latest()->paginate(15);

    return response()->json([
        'status' => 'success',
        'message' => 'Registro de auditoría y trazabilidad administrativa obtenido exitosamente.',
        'data' => $auditorias
    ], 200);
}
}
