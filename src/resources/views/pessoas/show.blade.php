<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pessoa->nome }} — CineApp</title>
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

    <main class="pt-20 pb-16 min-h-screen">

        {{-- Hero da Pessoa --}}
        <section class="border-b border-zinc-800 pb-10 mb-10">
            <div class="max-w-5xl mx-auto px-6">
                <div class="flex flex-col sm:flex-row gap-8 pt-6">

                    {{-- Foto principal --}}
                    <div class="shrink-0">
                        @if($pessoa->imagens->isNotEmpty())
                            <img src="{{ asset('storage/' . $pessoa->imagens->first()->caminho) }}"
                                 alt="{{ $pessoa->nome }}"
                                 class="w-40 h-52 object-cover rounded-lg border border-zinc-700 shadow-xl">
                        @else
                            <div class="w-40 h-52 rounded-lg border border-zinc-700 bg-zinc-800 flex items-center justify-center text-zinc-500 text-sm">
                                Sem foto
                            </div>
                        @endif
                    </div>

                    {{-- Dados principais --}}
                    <div class="flex-1">
                        @php
                            $papeis = [];
                            if ($pessoa->ator)    $papeis[] = 'Ator';
                            if ($pessoa->diretor) $papeis[] = 'Diretor';
                            if ($pessoa->produtor)$papeis[] = 'Produtor';
                            if ($pessoa->escritor)$papeis[] = 'Escritor';
                        @endphp

                        @if(count($papeis))
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($papeis as $papel)
                                    <span class="text-xs px-2 py-1 rounded bg-amber-400/10 text-amber-400 border border-amber-400/20">
                                        {{ $papel }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <h1 class="text-3xl sm:text-4xl font-bold mb-3">{{ $pessoa->nome }}</h1>

                        <div class="flex flex-wrap items-center gap-4 text-zinc-400 text-sm mb-5">
                            @if($pessoa->nacionalidade)
                                <span>{{ $pessoa->nacionalidade }}</span>
                            @endif
                            @if($pessoa->data_nascimento)
                                <span>Nascimento: {{ $pessoa->data_nascimento->format('d/m/Y') }}</span>
                            @endif
                        </div>

                        @if($pessoa->biografia)
                            <p class="text-zinc-300 text-sm leading-relaxed max-w-2xl">{{ $pessoa->biografia }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-5xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Filmografia --}}
                <div class="lg:col-span-2 space-y-10">

                    @php
                        $filmesVinculados = collect();
                        if ($pessoa->ator)    $filmesVinculados = $filmesVinculados->merge($pessoa->ator->filmes);
                        if ($pessoa->diretor) $filmesVinculados = $filmesVinculados->merge($pessoa->diretor->filmes);
                        if ($pessoa->produtor)$filmesVinculados = $filmesVinculados->merge($pessoa->produtor->filmes);
                        if ($pessoa->escritor)$filmesVinculados = $filmesVinculados->merge($pessoa->escritor->filmes);
                        $filmesUnicos = $filmesVinculados->unique('id')->sortByDesc('data_lancamento');
                    @endphp

                    @if($filmesUnicos->isNotEmpty())
                        <section>
                            <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Filmografia</h2>
                            <div class="space-y-3">
                                @foreach($filmesUnicos as $filme)
                                    <a href="{{ route('filmes.show', $filme) }}"
                                       class="flex items-center gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-4 hover:border-zinc-600 transition">
                                        @if($filme->imagens->isNotEmpty())
                                            <img src="{{ asset('storage/' . $filme->imagens->first()->caminho) }}"
                                                 alt="{{ $filme->nome }}"
                                                 class="w-12 h-16 object-cover rounded border border-zinc-700 shrink-0">
                                        @else
                                            <div class="w-12 h-16 bg-zinc-800 rounded border border-zinc-700 shrink-0"></div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-white">{{ $filme->nome }}</p>
                                            <p class="text-zinc-500 text-xs mt-1">
                                                {{ $filme->data_lancamento?->format('Y') ?? '—' }}
                                                @if($filme->duracao) · {{ $filme->duracao }} min @endif
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Galeria de fotos --}}
                    @if($pessoa->imagens->count() > 1)
                        <section>
                            <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Galeria</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                @foreach($pessoa->imagens->skip(1) as $imagem)
                                    <img src="{{ asset('storage/' . $imagem->caminho) }}"
                                         alt="{{ $imagem->nome }}"
                                         class="w-full h-36 object-cover rounded-lg border border-zinc-800">
                                @endforeach
                            </div>
                        </section>
                    @endif

                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-4 space-y-4 text-sm">
                        @if($pessoa->genero)
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-1">Gênero</p>
                                <p class="text-white">{{ $pessoa->genero }}</p>
                            </div>
                        @endif
                        @if($pessoa->nacionalidade)
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-1">Nacionalidade</p>
                                <p class="text-white">{{ $pessoa->nacionalidade }}</p>
                            </div>
                        @endif
                        @if($pessoa->data_nascimento)
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-1">Data de Nascimento</p>
                                <p class="text-white">{{ $pessoa->data_nascimento->format('d/m/Y') }}</p>
                            </div>
                        @endif
                        @if(count($papeis))
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-2">Papéis</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($papeis as $papel)
                                        <span class="px-2 py-0.5 text-xs bg-zinc-800 text-zinc-300 rounded">{{ $papel }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('busca') }}"
                       class="block text-center text-sm text-zinc-400 hover:text-white transition">
                        ← Voltar à busca
                    </a>
                </div>

            </div>
        </div>

    </main>

</body>
</html>

