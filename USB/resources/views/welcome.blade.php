<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRIE - Universidad Simón Bolívar</title>
    <!-- Incluyendo Tailwind CSS CDN para el diseño responsive -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Barra superior (Navbar) Responsive -->
    <nav class="bg-red-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center flex-col sm:flex-row py-2 sm:py-0">

                <!-- Logo institucional de la Universidad Simón Bolívar -->
                <div class="flex items-center space-x-3">
                    <span class="font-bold text-lg tracking-wider">SIRIE - USB Cúcuta</span>
                </div>

                <!-- Menú de navegación dinámico según el rol -->
                <div class="flex flex-wrap justify-center space-x-4 my-2 sm:my-0">
                    <a href="#" class="hover:bg-red-800 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                    <a href="#" class="hover:bg-red-800 px-3 py-2 rounded-md text-sm font-medium">Mis Solicitudes</a>

                    @auth
                        @php
                            $userRole = Auth::user()->role->nombre ?? '';
                        @endphp

                        @if(in_array($userRole, ['Coordinador de Carrera', 'Rector', 'Administrador']))
                            <a href="/bandeja-gestion" class="hover:bg-red-800 px-3 py-2 rounded-md text-sm font-medium">Bandeja de Gestión</a>
                            <a href="/auditoria-expedientes" class="hover:bg-red-800 px-3 py-2 rounded-md text-sm font-medium">Auditoría</a>
                        @endif
                    @endauth
                </div>

                <!-- Perfil de usuario con su fotografía asociada y botón de cerrar sesión -->
                <div class="flex items-center space-x-3">
                    @auth
                        <div class="flex items-center space-x-2">
                            @if(Auth::user()->foto_perfil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border-2 border-white">
                            @else
                                <div class="w-9 h-9 rounded-full bg-red-700 flex items-center justify-center font-bold text-white border-2 border-white">
                                    {{ substr(Auth::user()->nombres ?? 'U', 0, 1) }}
                                </div>
                            @endif
                            <span class="text-sm font-medium hidden md:inline">{{ Auth::user()->nombres ?? 'Usuario' }}</span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-950 hover:bg-black text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                Salir
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm bg-white text-red-900 px-3 py-1 rounded font-semibold">Ingresar</a>
                    @authend
                </div>

            </div>
        </div>
    </nav>

    <!-- Contenido Principal de la Vista -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Pie de página institucional -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        Universidad Simón Bolívar - Extensión Cúcuta &copy; 2026 Sistema SIRIE
    </footer>

</body>
</html>
