<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIRIE</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-[#111827]/80 backdrop-blur-md border border-gray-800 rounded-2xl shadow-2xl relative">

        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/20 border border-cyan-400/30">
                <span class="text-white font-black text-2xl tracking-wider">SI</span>
            </div>
        </div>

        <h2 class="text-center text-2xl font-bold tracking-widest text-cyan-400 mb-8 uppercase">
            SIRIE - USB
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-900/50 border border-red-500 text-red-200 text-xs rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Identificación :
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 bg-[#0b0f19] border border-gray-800 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition"
                    placeholder="Usuario*">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    Contraseña :
                </label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 bg-[#0b0f19] border border-gray-800 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400 transition"
                    placeholder="**********">
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-cyan-400 to-blue-500 text-slate-950 font-bold rounded-lg shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/50 hover:from-cyan-300 hover:to-blue-400 transition-all duration-300 uppercase tracking-wider text-sm">
                    Ingresar
                </button>
            </div>
        </form>
    </div>

</body>
</html>
