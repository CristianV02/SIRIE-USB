<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeja de Gestión - SIRIE USB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-100 min-h-screen flex flex-col">

    <header class="bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <a href="/dashboard" class="text-cyan-400 hover:text-cyan-300 text-xs font-bold uppercase tracking-wider">&larr; Volver al Dashboard</a>
        </div>
        <h1 class="text-lg font-bold text-cyan-400 tracking-wider">SIRIE - BANDEJA INSTITUCIONAL</h1>
        <div class="text-xs text-gray-400">Panel de Coordinación</div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto p-6 md:p-10 space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-black text-white">Solicitudes Recibidas</h2>
            <span class="px-3 py-1 bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 text-xs rounded-full font-semibold">Total: 3 activas</span>
        </div>

        <div class="bg-[#111827]/80 border border-gray-800 rounded-2xl overflow-hidden shadow-xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-800 text-gray-400 text-xs uppercase tracking-wider bg-gray-900/50">
                        <th class="p-4">ID</th>
                        <th class="p-4">Estudiante / Emisor</th>
                        <th class="p-4">Asunto</th>
                        <th class="p-4">Estado</th>
                        <th class="p-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-sm">
                    <tr class="hover:bg-gray-900/30 transition">
                        <td class="p-4 font-mono text-cyan-400">#001</td>
                        <td class="p-4">Cristian Vargas</td>
                        <td class="p-4 text-gray-200">Automatización de reportes de laboratorios</td>
                        <td class="p-4"><span class="px-2 py-1 bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs rounded-md">Pendiente</span></td>
                        <td class="p-4 text-right"><button class="px-3 py-1 bg-cyan-500/20 text-cyan-400 border border-cyan-500/40 rounded text-xs font-semibold hover:bg-cyan-500 hover:text-slate-950 transition">Revisar</button></td>
                    </tr>
                    <tr class="hover:bg-gray-900/30 transition">
                        <td class="p-4 font-mono text-cyan-400">#002</td>
                        <td class="p-4">Ana María Pérez</td>
                        <td class="p-4 text-gray-200">Idea app móvil para clasificación de alimentos</td>
                        <td class="p-4"><span class="px-2 py-1 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs rounded-md">Aprobada</span></td>
                        <td class="p-4 text-right"><button class="px-3 py-1 bg-cyan-500/20 text-cyan-400 border border-cyan-500/40 rounded text-xs font-semibold hover:bg-cyan-500 hover:text-slate-950 transition">Revisar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
