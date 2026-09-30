<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Solicitud - SIRIE USB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-100 min-h-screen flex flex-col">

    <header class="bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <a href="/dashboard" class="text-cyan-400 hover:text-cyan-300 text-xs font-bold uppercase tracking-wider">&larr; Volver al Dashboard</a>
        </div>
        <h1 class="text-lg font-bold text-cyan-400 tracking-wider">SIRIE - NUEVA SOLICITUD / IDEA</h1>
        <div class="text-xs text-gray-400">{{ Auth::user()->nombres ?? 'Usuario' }}</div>
    </header>

    <main class="flex-1 max-w-3xl w-full mx-auto p-6 md:p-10">
        <div class="p-8 bg-[#111827]/80 backdrop-blur-md border border-gray-800 rounded-2xl shadow-xl">
            <h2 class="text-2xl font-black text-white mb-2">Radicar Solicitud Institucional</h2>
            <p class="text-gray-400 text-xs mb-8">Diligencia el siguiente formulario para enviar tu propuesta o requerimiento a la coordinación de la facultad.</p>

            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tipo de Solicitud</label>
                    <select class="w-full px-4 py-3 bg-[#0b0f19] border border-gray-800 rounded-lg text-white focus:outline-none focus:border-cyan-400">
                        <option>Propuesta Estudiantil / Idea</option>
                        <option>Petición Académica</option>
                        <option>Reporte Técnico / Infraestructura</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Título o Asunto</label>
                    <input type="text" placeholder="Ej: Propuesta de mejora para laboratorios de redes" class="w-full px-4 py-3 bg-[#0b0f19] border border-gray-800 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-cyan-400">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Descripción Detallada</label>
                    <rows="4" class="w-full px-4 py-3 bg-[#0b0f19] border border-gray-800 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-cyan-400 h-32 block" contenteditable="true" placeholder="Escribe los detalles de tu solicitud..."></rows>
                </div>

                <div>
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-400 to-blue-500 text-slate-950 font-bold rounded-lg shadow-lg shadow-cyan-500/30 hover:from-cyan-300 hover:to-blue-400 transition uppercase tracking-wider text-sm">
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
