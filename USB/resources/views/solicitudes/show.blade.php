@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 space-y-6">

    <!-- Botón de retorno -->
    <div>
        <a href="{{ url()->previous() }}" class="text-sm font-medium text-red-800 hover:underline">&larr; Volver al listado</a>
    </div>

    <!-- Cabecera del Radicado -->
    <div class="bg-white shadow-md rounded-lg p-6 border-l-4
        @php
            $ultimoEstado = $solicitud->trazabilidades->last()->estado ?? 'Registrada';
            $badgeColor = match($ultimoEstado) {
                'Registrada' => 'border-blue-600 bg-blue-50 text-blue-800',
                'En Revisión' => 'border-yellow-500 bg-yellow-50 text-yellow-800',
                'En Proceso' => 'border-orange-500 bg-orange-50 text-orange-800',
                'Escalada' => 'border-red-600 bg-red-50 text-red-800',
                'Resuelta' => 'border-green-600 bg-green-50 text-green-800',
                default => 'border-gray-500 bg-gray-50 text-gray-800'
            };
        @endphp
        {{ explode(' ', $badgeColor)[0] }}">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Expediente / Radicado</span>
                <h1 class="text-2xl font-bold text-gray-900">{{ $solicitud->codigo_radicado }}</h1>
                <p class="text-sm text-gray-600 mt-1">Código Institucional: <span class="font-semibold">{{ $solicitud->codigo_institucional }}</span> | Asignatura: <span class="font-semibold">{{ $solicitud->asignatura ?? 'N/A' }}</span></p>
            </div>

            <!-- Badge de Estado Actual -->
            <div>
                <span class="px-3.5 py-1.5 rounded-full text-sm font-bold border {{ $badgeColor }}">
                    {{ $ultimoEstado }}
                </span>
            </div>
        </div>

        @if($solicitud->evidencia_path)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ asset('storage/' . $solicitud->evidencia_path) }}" target="_blank" class="inline-flex items-center text-sm font-semibold text-red-800 hover:underline">
                    📂 Ver Evidencia Adjunta (Soporte)
                </a>
            </div>
        @endif
    </div>

    <!-- Timeline (Línea de tiempo vertical de Trazabilidad - Módulo 3.6) -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Línea de Tiempo y Trazabilidad del Trámite</h3>

        <div class="relative border-l-2 border-red-200 ml-4 space-y-8">
            @foreach($solicitud->trazabilidades as $trazabilidad)
                <div class="relative pl-6">
                    <!-- Punto indicador en la línea -->
                    <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-red-800 border-2 border-white"></div>

                    <!-- Contenido del evento cronológico -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 shadow-sm">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                            <span class="font-bold text-red-900 text-sm">Estado: {{ $trazabilidad->estado }}</span>
                            <span class="text-xs text-gray-500 font-medium">
                                {{ $trazabilidad->created_at->format('d/m/Y') }} a las {{ $trazabilidad->created_at->format('H:i') }}
                            </span>
                        </div>
                        <p class="text-xs font-semibold text-gray-600 mb-1">Rol Responsable: <span class="text-gray-800">{{ $trazabilidad->rol_responsable }}</span></p>
                        <p class="text-sm text-gray-700 bg-white p-3 rounded border border-gray-100 mt-2">
                            <strong>Observaciones:</strong> {{ $trazabilidad->observaciones }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
