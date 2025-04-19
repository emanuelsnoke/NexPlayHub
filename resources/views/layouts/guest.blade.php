<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NexPlayHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-[#000000] via-[#1a0e2a] to-[#503896] min-h-screen flex items-center justify-center text-white transition-colors duration-300">

    <div class="w-full sm:max-w-md px-6 py-4 bg-white rounded-xl shadow-xl">
        {{ $slot }}
    </div>

</body>
</html>
