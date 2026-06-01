<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Busca — CineApp</title>
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
                    <a href="{{ route('dashboard') }}" class="text-sm text-zinc-300 hover:text-white transition">Dashboard</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.index') }}" class="text-sm text-amber-400 hover:text-amber-300 transition">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-zinc-400 hover:text-white transition">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-zinc-300 hover:text-white transition">Entrar</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-amber-400 text-zinc-900 rounded-lg hover:bg-amber-300 transition">Criar conta</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="pt-24 pb-16 min-h-screen">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Barra de busca --}}
            <form method="GET" action="{{ route('busca') }}" class="mb-10">
                <div class="flex gap-2">
                    <input type="text" name="q" value="{{ $termo ?? '' }}"
                           placeholder="Buscar filmes, atores, diretores..."
                           autofocus
                           class="flex-1 bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent text-sm">
                    <button type="submit"
                            class="px-6 py-3 bg-amber-400 text-zinc-900 font-semibold rounded-lg hover:bg-amber-300 transition text-sm">
                        Buscar
                    </button>
                </div>
            </form>

            @if(!isset($filmes))
                {{-- Estado inicial --}}
                <p class="text-zinc-500 text-center text-sm">Digite um termo para buscar no catálogo.</p>
            @else
                @php
                    $total = $filmes->count() + $atores->count() + $diretores->count() + $escritores->count() + $produtoras->count();
                @endphp

                <p class="text-zinc-400 text-sm mb-8">
                    {{ $total }} resultado(s) para "<span class="text-white font-medium">{{ $termo }}</span>"
                </p>

                {{-- Filmes --}}
                @if($filmes->isNotEmpty())
                    <section class="mb-10">
                        <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Filmes</h2>
                        <div class="space-y-3">
                            @foreach($filmes as $filme)
                                <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-4">
                                    <p class="font-semibold text-white">{{ $filme->nome }}</p>
                                    <p class="text-zinc-500 text-xs mt-1">
                                        {{ $filme->data_lancamento?->format('Y') }}
                                        @if($filme->duracao) · {{ $filme->duracao }} min @endif
                                        @if($filme->classificacao) · {{ $filme->classificacao }} @endif
                                    </p>
                                    @if($filme->sinopse)
                                        <p class="text-zinc-400 text-sm mt-2 line-clamp-2">{{ $filme->sinopse }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Atores --}}
                @if($atores->isNotEmpty())
                    <section class="mb-10">
                        <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Atores</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($atores as $ator)
                                <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-4">
                                    <p class="font-medium text-white text-sm">{{ $ator->pessoa->nome }}</p>
                                    @if($ator->pessoa->nacionalidade)
                                        <p class="text-zinc-500 text-xs mt-1">{{ $ator->pessoa->nacionalidade }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Diretores --}}
                @if($diretores->isNotEmpty())
                    <section class="mb-10">
                        <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Diretores</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($diretores as $diretor)
                                <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-4">
                                    <p class="font-medium text-white text-sm">{{ $diretor->pessoa->nome }}</p>
                                    @if($diretor->pessoa->nacionalidade)
                                        <p class="text-zinc-500 text-xs mt-1">{{ $diretor->pessoa->nacionalidade }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Escritores --}}
                @if($escritores->isNotEmpty())
                    <section class="mb-10">
                        <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Escritores / Roteiristas</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($escritores as $escritor)
                                <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-4">
                                    <p class="font-medium text-white text-sm">{{ $escritor->pessoa->nome }}</p>
                                    @if($escritor->pessoa->nacionalidade)
                                        <p class="text-zinc-500 text-xs mt-1">{{ $escritor->pessoa->nacionalidade }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Produtoras --}}
                @if($produtoras->isNotEmpty())
                    <section class="mb-10">
                        <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Produtoras / Estúdios</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($produtoras as $produtora)
                                <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-4">
                                    <p class="font-medium text-white text-sm">{{ $produtora->nome }}</p>
                                    @if($produtora->local)
                                        <p class="text-zinc-500 text-xs mt-1">{{ $produtora->local }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($total === 0)
                    <div class="text-center py-16">
                        <p class="text-zinc-500 text-sm">Nenhum resultado encontrado para "<span class="text-white">{{ $termo }}</span>".</p>
                        <p class="text-zinc-600 text-xs mt-2">Tente usar termos diferentes.</p>
                    </div>
                @endif
            @endif
        </div>
    </main>

</body>
</html>
