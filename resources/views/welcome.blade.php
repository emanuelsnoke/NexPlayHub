<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NexPlayHub</title>
        <link rel="icon" href="{{ asset('png.png') }}" type="image/x-icon">


        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Fonte Inter -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            primary: '#503896',
                        },
                    },
                },
                darkMode: 'class',
            }
        </script>
    </head>
    <body class="bg-gradient-to-br from-[#000000] via-[#1a0e2a] to-[#503896] dark:bg-[#0a0a0a] text-[#262626] dark:text-[#f1f1f1] font-sans flex items-center justify-center min-h-screen transition-colors duration-300">

        <div class="w-full max-w-md p-8 bg-white dark:bg-[#1a1a1a] rounded-2xl shadow-2xl border border-gray-100 dark:border-[#2b2b2b]">
            
            <!-- Logo -->
            <img src="/icone.png" alt="Logo NexPlayHub" class="w-48 h-48 mx-auto block mb-4">


            <!-- Subtítulo -->
            <p class="text-center text-gray-600 dark:text-gray-400 mb-8">
                Bem-vindo! Faça login ou registre-se para começar.
            </p>

            <!-- Navegação -->
            @if (Route::has('login'))
                <nav class="flex flex-col space-y-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="w-full py-3 text-center bg-primary text-white rounded-md font-medium hover:bg-[#3f2d79] transition">
                            Ir para o Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full py-3 text-center border border-primary text-primary rounded-md hover:bg-primary hover:text-white transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="w-full py-3 text-center bg-primary text-white rounded-md hover:bg-[#3f2d79] transition">
                                Registrar-se
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </body>
</html>
