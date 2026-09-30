<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Institucional - SIRIE USB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-100 min-h-screen flex flex-col">

    <header class="bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <a href="/dashboard" class="text-cyan-400 hover:text-cyan-300 text-xs font-bold uppercase tracking-wider">&larr; Volver al Dashboard</a>
        </div>
        <h1 class="text-lg font-bold text-cyan-400 tracking-wider">SIRIE - PERFIL DE USUARIO</h1>
        <div class="text-xs text-gray-400">Configuración</div>
    </header>

    <main class="flex-1 max-w-3xl w-full mx-auto p-6 md:p-10 space-y-6">
        <div class="p-8 bg-[#111827]/80 backdrop-blur-md border border-gray-800 rounded-2xl shadow-xl space-y-6">
            <div class="flex items-center space-x-4 pb-6 border-b border-gray-800">
                <div class="w-16 h-16 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 font-bold text-2xl">
                    {{ substr(Auth::user()->nombres ?? 'U', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">{{ Auth::user()->nombres ?? 'Usuario' }} {{ Auth::user()->apellidos ?? '' }}</h2>
                    <p class="text-xs text-cyan-400">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-sm font-bold text-gray-300 uppercase tracking-wider">Información de Cuenta</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div class="p-4 bg-gray-900/50 border border-gray-800 rounded-xl">
                        <span class="text-gray-500 block mb-1">Código Institucional</span>
                        <span class="font-mono text-white text-sm">USB-2026-01</span>
                    </div>
                    <div class="p-4 bg-gray-900/50 border border-gray-800 rounded-xl">
                        <span class="text-gray-500 block mb-1">Rol Asignado</span>
                        <span class="text-cyan-400 font-semibold text-sm">Administrador / Coordinador</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
