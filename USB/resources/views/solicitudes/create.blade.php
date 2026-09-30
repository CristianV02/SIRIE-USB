@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 space-y-8">

    <!-- Tarjeta de Formulario de Creación (Módulos 3.2, 3.3, 3.4, 3.5) -->
    <div class="bg-white shadow-md rounded-lg p-6 border-t-4 border-red-800">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Radicación de Quejas e Ideas (SIRIE)</h2>

        <!-- Alertas de éxito o errores -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/solicitudes') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="pqrForm">
            @csrf

            <!-- Selector de tipología -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de Solicitud</label>
                <select name="tipo" id="tipoSelect" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required onchange="toggleCampos()">
                    <option value="Queja">Queja</option>
                    <option value="Idea">Idea</option>
                    <option value="Ambas">Ambas (Queja e Idea)</option>
                </select>
            </div>

            <!-- Campos de texto generales -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Código Institucional</label>
                    <input type="text" name="codigo_institucional" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Asignatura</label>
                    <input type="text" name="asignatura" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border">
                </div>
            </div>

            <!-- Campos condicionales dinámicos -->
            <div id="campoQueja" class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Detalle de la Inconformidad</label>
                <textarea name="detalle_inconformidad" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
            </div>

            <div id="campoIdea" class="space-y-2" style="display: none;">
                <label class="block text-sm font-medium text-gray-700">Propuesta de Mejora</label>
                <textarea name="propuesta_mejora" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"></textarea>
            </div>

            <!-- Zona de evidencias (Módulo 3.4) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Adjuntar Evidencia (PDF, JPG, PNG - Máx 10 MB)</label>
                <input type="file" name="evidencia" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 border rounded-md">
            </div>

            <!-- Botón Radicar Solicitud -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-red-800 text-white py-2.5 px-4 rounded-md hover:bg-red-900 transition font-semibold">
                    Radicar Solicitud
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Mis Trámites y Radicados -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Mis Trámites Activos</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Radicado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignatura</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @isset($misSolicitudes)
                        @foreach($misSolicitudes as $solicitud)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-800">{{ $solicitud->codigo_radicado }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $solicitud->tipo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $solicitud->asignatura ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="#" class="text-red-600 hover:text-red-900 font-medium">Ver Trazabilidad</a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No hay trámites registrados aún.</td>
                        </tr>
                    @endisset
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Script para mostrar/ocultar campos dinámicos según el tipo -->
<script>
    function toggleCampos() {
        const tipo = document.getElementById('tipoSelect').value;
        const campoQueja = document.getElementById('campoQueja');
        const campoIdea = document.getElementById('campoIdea');

        if (tipo === 'Queja') {
            campoQueja.style.display = 'block';
            campoIdea.style.display = 'none';
        } else if (tipo === 'Idea') {
            campoQueja.style.display = 'none';
            campoIdea.style.display = 'block';
        } else {
            campoQueja.style.display = 'block';
            campoIdea.style.display = 'block';
        }
    }
</script>
@endsection
