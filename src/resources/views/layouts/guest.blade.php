<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CineApp</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-zinc-950 text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            <div class="mb-6 text-center">
                <a href="/" class="text-2xl font-bold tracking-tight">
                    <span class="text-amber-400">Cine</span><span class="text-white">App</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-zinc-900 border border-zinc-800 shadow-xl overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
