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
                    $total = $filmes->count() + $pessoas->count() + $produtoras->count();
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
                                <a href="{{ route('filmes.show', $filme) }}"
                                   class="flex gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-4 hover:border-zinc-600 transition">
                                    @if($filme->imagens->isNotEmpty())
                                        <img src="{{ asset('storage/' . $filme->imagens->first()->caminho) }}"
                                             alt="{{ $filme->nome }}"
                                             class="w-14 h-20 object-cover rounded border border-zinc-700 shrink-0">
                                    @else
                                        <div class="w-14 h-20 bg-zinc-800 rounded border border-zinc-700 shrink-0 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-white">{{ $filme->nome }}</p>
                                        <p class="text-zinc-500 text-xs mt-1">
                                            {{ $filme->data_lancamento?->format('Y') }}
                                            @if($filme->duracao) · {{ $filme->duracao }} min @endif
                                            @if($filme->classificacao) · {{ $filme->classificacao }} @endif
                                        </p>
                                        @if($filme->sinopse)
                                            <p class="text-zinc-400 text-sm mt-2 line-clamp-2">{{ $filme->sinopse }}</p>
                                        @endif
                                        @if($filme->atores->isNotEmpty())
                                            <div class="mt-2 flex flex-wrap gap-1">
                                                <span class="text-zinc-600 text-xs mr-1">Elenco:</span>
                                                @foreach($filme->atores->take(5) as $ator)
                                                    <span class="text-xs px-2 py-0.5 bg-zinc-800 text-zinc-300 rounded">
                                                        {{ $ator->pessoa->nome }}
                                                    </span>
                                                @endforeach
                                                @if($filme->atores->count() > 5)
                                                    <span class="text-zinc-600 text-xs">+{{ $filme->atores->count() - 5 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Pessoas (atores, diretores, produtores, escritores) --}}
                @if($pessoas->isNotEmpty())
                    <section class="mb-10">
                        <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Pessoas</h2>
                        <div class="space-y-3">
                            @foreach($pessoas as $pessoa)
                                @php
                                    $papeis = [];
                                    if ($pessoa->ator)    $papeis[] = 'Ator';
                                    if ($pessoa->diretor) $papeis[] = 'Diretor';
                                    if ($pessoa->produtor)$papeis[] = 'Produtor';
                                    if ($pessoa->escritor)$papeis[] = 'Escritor';

                                    $todosFilmes = collect();
                                    if ($pessoa->ator)    $todosFilmes = $todosFilmes->merge($pessoa->ator->filmes);
                                    if ($pessoa->diretor) $todosFilmes = $todosFilmes->merge($pessoa->diretor->filmes);
                                    if ($pessoa->produtor)$todosFilmes = $todosFilmes->merge($pessoa->produtor->filmes);
                                    if ($pessoa->escritor)$todosFilmes = $todosFilmes->merge($pessoa->escritor->filmes);
                                    $todosFilmes = $todosFilmes->unique('id')->sortBy('nome');
                                @endphp
                                <a href="{{ route('pessoas.show', $pessoa) }}"
                                   class="flex gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-4 hover:border-zinc-600 transition">
                                    {{-- Foto --}}
                                    @if($pessoa->imagens->isNotEmpty())
                                        <img src="{{ asset('storage/' . $pessoa->imagens->first()->caminho) }}"
                                             alt="{{ $pessoa->nome }}"
                                             class="w-14 h-14 object-cover rounded-full border border-zinc-700 shrink-0 self-start mt-0.5">
                                    @else
                                        <div class="w-14 h-14 bg-zinc-800 rounded-full border border-zinc-700 shrink-0 self-start mt-0.5 flex items-center justify-center text-zinc-400 text-lg font-bold">
                                            {{ mb_substr($pessoa->nome, 0, 1) }}
                                        </div>
                                    @endif

                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="font-semibold text-white">{{ $pessoa->nome }}</p>
                                            @foreach($papeis as $papel)
                                                <span class="text-xs px-1.5 py-0.5 rounded bg-amber-400/10 text-amber-400 border border-amber-400/20">{{ $papel }}</span>
                                            @endforeach
                                        </div>

                                        @if($pessoa->nacionalidade)
                                            <p class="text-zinc-500 text-xs mt-1">{{ $pessoa->nacionalidade }}</p>
                                        @endif

                                        @if($todosFilmes->isNotEmpty())
                                            <div class="mt-3 space-y-1.5">
                                                @foreach($todosFilmes->take(5) as $filmeItem)
                                                    <div class="flex items-center gap-2">
                                                        @if($filmeItem->imagens->isNotEmpty())
                                                            <img src="{{ asset('storage/' . $filmeItem->imagens->first()->caminho) }}"
                                                                 alt="{{ $filmeItem->nome }}"
                                                                 class="w-8 h-11 object-cover rounded border border-zinc-700 shrink-0">
                                                        @else
                                                            <div class="w-8 h-11 bg-zinc-800 rounded border border-zinc-700 shrink-0"></div>
                                                        @endif
                                                        <div class="min-w-0">
                                                            <p class="text-zinc-300 text-xs font-medium truncate">{{ $filmeItem->nome }}</p>
                                                            @if($filmeItem->data_lancamento)
                                                                <p class="text-zinc-600 text-xs">{{ $filmeItem->data_lancamento->format('Y') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($todosFilmes->count() > 5)
                                                    <p class="text-zinc-600 text-xs">+ {{ $todosFilmes->count() - 5 }} filmes</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </a>
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
