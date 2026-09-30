@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 space-y-6">

    <!-- Título de la sección -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Bandeja de Gestión Administrativa (SIRIE)</h1>
        <span class="text-sm bg-red-100 text-red-800 font-semibold px-3 py-1 rounded-full">Panel Directivo / Coordinación</span>
    </div>

    <!-- Panel de Filtros Avanzados (Módulo 3.7) -->
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <form method="GET" action="{{ url('/bandeja-gestion') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Código Institucional</label>
                <input type="text" name="codigo_institucional" value="{{ request('codigo_institucional') }}" placeholder="Ej. 100..." class="w-full rounded-md border-gray-300 shadow-sm p-2 border text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="text" name="correo" value="{{ request('correo') }}" placeholder="correo@ufps..." class="w-full rounded-md border-gray-300 shadow-sm p-2 border text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Tipo de Solicitud</label>
                <select name="tipo" class="w-full rounded-md border-gray-300 shadow-sm p-2 border text-sm">
                    <option value="">Todos</option>
                    <option value="Queja" {{ request('tipo') == 'Queja' ? 'selected' : '' }}>Queja</option>
                    <option value="Idea" {{ request('tipo') == 'Idea' ? 'selected' : '' }}>Idea</option>
                    <option value="Ambas" {{ request('tipo') == 'Ambas' ? 'selected' : '' }}>Ambas</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Estado Actual</label>
                <select name="estado" class="w-full rounded-md border-gray-300 shadow-sm p-2 border text-sm">
                    <option value="">Todos</option>
                    <option value="Registrada" {{ request('estado') == 'Registrada' ? 'selected' : '' }}>Registrada</option>
                    <option value="En Revisión" {{ request('estado') == 'En Revisión' ? 'selected' : '' }}>En Revisión</option>
                    <option value="En Proceso" {{ request('estado') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="Escalada" {{ request('estado') == 'Escalada' ? 'selected' : '' }}>Escalada</option>
                    <option value="Resuelta" {{ request('estado') == 'Resuelta' ? 'selected' : '' }}>Resuelta</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="bg-red-800 hover:bg-red-900 text-white px-4 py-2 rounded-md text-sm font-semibold transition w-full">Filtrar</button>
                <a href="{{ url('/bandeja-gestion') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm font-semibold transition text-center">Limpiar</a>
            </div>
        </form>
    </div>

    <!-- Tabla de Gestión de Expedientes -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Radicado</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiante / Correo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asignatura</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado Actual</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($solicitudes ?? [] as $solicitud)
                        @php
                            $ultimoEstado = $solicitud->trazabilidades->last()->estado ?? 'Registrada';
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <!-- Foto del usuario -->
                            <td class="px-4 py-4 whitespace-nowrap">
                                @if($solicitud->user && $solicitud->user->foto_perfil)
                                    <img src="{{ asset('storage/' . $solicitud->user->foto_perfil) }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-gray-300 flex items-center justify-center font-bold text-gray-700 text-xs">
                                        {{ substr($solicitud->user->nombres ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <!-- Radicado -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-red-800">
                                {{ $solicitud->codigo_radicado }}
                            </td>
                            <!-- Estudiante -->
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $solicitud->user->nombres ?? 'Desconocido' }}</div>
                                <div class="text-xs text-gray-500">{{ $solicitud->user->email ?? 'N/A' }}</div>
                            </td>
                            <!-- Tipo -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $solicitud->tipo }}
                            </td>
                            <!-- Asignatura -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $solicitud->asignatura ?? 'N/A' }}
                            </td>
                            <!-- Estado Actual -->
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $ultimoEstado == 'Registrada' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $ultimoEstado == 'En Revisión' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $ultimoEstado == 'En Proceso' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $ultimoEstado == 'Escalada' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $ultimoEstado == 'Resuelta' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ $ultimoEstado }}
                                </span>
                            </td>
                            <!-- Menú de Acciones Rápidas -->
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="inline-flex space-x-2">
                                    <!-- Ver Trazabilidad -->
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-2.5 py-1 rounded text-xs font-semibold">Detalles</a>
                                    <!-- Generar Oficio PDF (Módulo 3.10) -->
                                    <form action="{{ url('/solicitudes/' . $solicitud->id . '/cerrar-oficio') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="observaciones" value="Cierre de caso aprobado y finalizado por directiva institucional.">
                                        <button type="submit" class="text-green-700 hover:text-green-900 bg-green-50 px-2.5 py-1 rounded text-xs font-semibold">PDF</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">No se encontraron solicitudes registradas con los filtros seleccionados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if(isset($solicitudes) && method_exists($solicitudes, 'links'))
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                {{ $solicitudes->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
