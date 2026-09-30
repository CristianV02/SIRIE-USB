<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Estudiantil - SIRIE USB</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-100 min-h-screen flex flex-col">

    <!-- Barra de Navegación Superior -->
    <header class="bg-[#111827]/80 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-md shadow-cyan-500/20">
                <span class="text-white font-black text-lg">SI</span>
            </div>
            <h1 class="text-xl font-bold tracking-wider text-cyan-400 uppercase">SIRIE - PORTAL ESTUDIANTIL</h1>
        </div>

        <!-- Información del Usuario y Botón Cerrar Sesión -->
        <div class="flex items-center space-x-4">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-gray-200">{{ Auth::user()->nombres ?? Auth::user()->name }}</p>
                <p class="text-xs text-cyan-400">Rol: Estudiante</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600/20 border border-red-500/50 hover:bg-red-600 hover:text-white text-red-400 text-xs font-semibold rounded-lg transition-all uppercase tracking-wider">
                    Salir
                </button>
            </form>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-6 md:p-10 space-y-8">

        <!-- Tarjeta de Bienvenida -->
        <div class="p-8 bg-[#111827]/80 backdrop-blur-md border border-gray-800 rounded-2xl shadow-xl relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-cyan-500/10 rounded-full blur-2xl"></div>
            <h2 class="text-3xl font-black text-white mb-2">¡Bienvenido a tu Portal Estudiantil!</h2>
            <p class="text-gray-400 text-sm max-w-2xl">
                Desde aquí puedes radicar nuevas solicitudes, quejas o ideas institucionales, verificar su estado de gestión y configurar los datos de tu cuenta.
            </p>
        </div>

        <!-- Cuadrícula de Opciones Exclusivas para Estudiantes -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Opción 1: Crear Solicitud / Queja / Idea -->
            <div class="p-6 bg-[#111827]/60 border border-gray-800 rounded-2xl hover:border-cyan-500/50 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 mb-4 group-hover:scale-110 transition-transform">
                    ✍️
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Crear Solicitud / Queja / Idea</h3>
                <p class="text-gray-400 text-xs mb-4">Envía tus propuestas académicas, peticiones o reportes directamente al área encargada.</p>
                <a href="/solicitudes/crear" class="inline-block text-cyan-400 hover:text-cyan-300 text-xs font-bold tracking-wider uppercase">Radicar &rarr;</a>
            </div>

            <!-- Opción 2: Ver Estado de mis Solicitudes -->
            <div class="p-6 bg-[#111827]/60 border border-gray-800 rounded-2xl hover:border-cyan-500/50 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 mb-4 group-hover:scale-110 transition-transform">
                    📊
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Estado de mis Solicitudes</h3>
                <p class="text-gray-400 text-xs mb-4">Consulta el avance, las respuestas y el estado actual de tus trámites ingresados.</p>
                <a href="/bandeja-gestion" class="inline-block text-blue-400 hover:text-blue-300 text-xs font-bold tracking-wider uppercase">Consultar &rarr;</a>
            </div>

            <!-- Opción 3: Configurar Perfil -->
            <div class="p-6 bg-[#111827]/60 border border-gray-800 rounded-2xl hover:border-cyan-500/50 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 mb-4 group-hover:scale-110 transition-transform">
                    ⚙️
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Configurar Perfil</h3>
                <p class="text-gray-400 text-xs mb-4">Actualiza tus datos personales, contraseña y revisa tu información institucional.</p>
                <a href="/perfil" class="inline-block text-purple-400 hover:text-purple-300 text-xs font-bold tracking-wider uppercase">Configurar &rarr;</a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-800 py-4 text-center text-xs text-gray-500">
        Universidad Simón Bolívar - Extensión Cúcuta &copy; 2026
    </footer>

</body>
</html>
