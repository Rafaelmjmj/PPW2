<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CineApp</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-zinc-950 text-white">

    {{-- Navbar --}}
    <header class="fixed top-0 w-full z-50 bg-zinc-950/90 backdrop-blur border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-amber-400 text-2xl font-bold tracking-tight">Cine<span class="text-white">App</span></span>
            </a>

            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="text-sm text-zinc-300 hover:text-white transition">Dashboard</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.index') }}"
                           class="text-sm text-amber-400 hover:text-amber-300 transition">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm text-zinc-400 hover:text-white transition">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-zinc-300 hover:text-white transition">Entrar</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 text-sm font-medium bg-amber-400 text-zinc-900 rounded-lg hover:bg-amber-300 transition">
                        Criar conta
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Hero --}}
    <section class="min-h-screen flex items-center justify-center pt-16">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <p class="text-amber-400 text-sm font-semibold uppercase tracking-widest mb-4">Catálogo de Cinema</p>
            <h1 class="text-5xl sm:text-6xl font-bold leading-tight mb-6">
                Descubra e avalie<br>
                <span class="text-amber-400">os melhores filmes</span>
            </h1>
            <p class="text-zinc-400 text-lg max-w-xl mx-auto mb-10">
                Explore filmes, conheça elencos, diretores e estúdios. Deixe sua avaliação e compartilhe sua opinião com outros cinéfilos.
            </p>

            {{-- Busca --}}
            <form method="GET" action="{{ route('busca') }}" class="flex gap-2 max-w-xl mx-auto mb-8">
                <input type="text" name="q"
                       placeholder="Buscar filmes, atores, diretores, produtoras..."
                       class="flex-1 bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent text-sm">
                <button type="submit"
                        class="px-6 py-3 bg-amber-400 text-zinc-900 font-semibold rounded-lg hover:bg-amber-300 transition text-sm">
                    Buscar
                </button>
            </form>

            @guest
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                       class="px-8 py-3 bg-amber-400 text-zinc-900 font-semibold rounded-lg hover:bg-amber-300 transition text-sm">
                        Começar agora
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-8 py-3 border border-zinc-700 text-zinc-300 font-semibold rounded-lg hover:border-zinc-500 hover:text-white transition text-sm">
                        Já tenho conta
                    </a>
                </div>
            @else
                <a href="{{ route('dashboard') }}"
                   class="inline-block px-8 py-3 bg-amber-400 text-zinc-900 font-semibold rounded-lg hover:bg-amber-300 transition text-sm">
                    Ir para o Dashboard
                </a>
            @endguest
        </div>
    </section>

    {{-- Features --}}
    <section class="py-24 border-t border-zinc-800">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div class="p-6">
                    <div class="text-amber-400 text-4xl mb-4">🎬</div>
                    <h3 class="font-semibold text-lg mb-2">Catálogo de Filmes</h3>
                    <p class="text-zinc-400 text-sm">Acesse informações completas sobre filmes, sinopses, elencos e datas de lançamento.</p>
                </div>
                <div class="p-6">
                    <div class="text-amber-400 text-4xl mb-4">⭐</div>
                    <h3 class="font-semibold text-lg mb-2">Avaliações</h3>
                    <p class="text-zinc-400 text-sm">Avalie e comente filmes. Veja o que outros usuários acharam de cada produção.</p>
                </div>
                <div class="p-6">
                    <div class="text-amber-400 text-4xl mb-4">🎭</div>
                    <h3 class="font-semibold text-lg mb-2">Elencos e Equipes</h3>
                    <p class="text-zinc-400 text-sm">Explore atores, diretores, produtores e escritores de cada projeto cinematográfico.</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
