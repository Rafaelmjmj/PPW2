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

    {{-- ======= CABEÇALHO ======= --}}
    <header class="fixed top-0 w-full z-50 bg-zinc-950/95 backdrop-blur border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center gap-4">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="shrink-0">
                <span class="text-amber-400 text-xl font-bold tracking-tight">Cine<span class="text-white">App</span></span>
            </a>

            {{-- Busca central --}}
            <form method="GET" action="{{ route('busca') }}" class="flex-1 flex gap-2 max-w-xl mx-auto">
                <input type="text" name="q"
                       placeholder="Buscar filmes, atores, diretores..."
                       class="flex-1 bg-zinc-900 border border-zinc-700 rounded-lg px-4 py-2 text-sm text-white placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                <button type="submit"
                        class="px-4 py-2 bg-amber-400 text-zinc-900 font-semibold rounded-lg hover:bg-amber-300 transition text-sm shrink-0">
                    Buscar
                </button>
            </form>

            {{-- Usuário --}}
            <div class="shrink-0 flex items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.index') }}" class="text-sm text-amber-400 hover:text-amber-300 transition">Admin</a>
                    @endif
                    <span class="text-zinc-400 text-sm hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-zinc-400 hover:text-white transition">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium border border-zinc-700 text-zinc-300 rounded-lg hover:border-zinc-500 hover:text-white transition">
                        Entrar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="pt-16">

        {{-- ======= CAROUSEL DE FILMES EM DESTAQUE ======= --}}
        @if($filmesCarousel->isNotEmpty())
        <section
            x-data="{
                current: 0,
                total: {{ $filmesCarousel->count() }},
                autoplay: null,
                start() {
                    this.autoplay = setInterval(() => this.next(), 5000);
                },
                stop() {
                    clearInterval(this.autoplay);
                },
                next() { this.current = (this.current + 1) % this.total; },
                prev() { this.current = (this.current - 1 + this.total) % this.total; }
            }"
            x-init="start()"
            @mouseenter="stop()"
            @mouseleave="start()"
            class="relative h-[520px] overflow-hidden bg-zinc-900"
        >
            @foreach($filmesCarousel as $i => $filme)
                <div
                    x-show="current === {{ $i }}"
                    x-transition:enter="transition-opacity duration-700"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0 flex"
                >
                    {{-- Imagem de fundo com blur --}}
                    <div class="absolute inset-0">
                        <img src="{{ asset('storage/' . $filme->imagens->first()->caminho) }}"
                             alt=""
                             class="w-full h-full object-cover opacity-20 blur-sm scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/80 to-transparent"></div>
                    </div>

                    {{-- Conteúdo --}}
                    <div class="relative z-10 max-w-7xl mx-auto px-8 flex items-center gap-8 w-full">
                        {{-- Poster --}}
                        <a href="{{ route('filmes.show', $filme) }}" class="shrink-0 hidden sm:block">
                            <img src="{{ asset('storage/' . $filme->imagens->first()->caminho) }}"
                                 alt="{{ $filme->nome }}"
                                 class="h-72 w-48 object-cover rounded-xl shadow-2xl border border-zinc-700 hover:scale-105 transition-transform duration-300">
                        </a>

                        {{-- Info --}}
                        <div class="flex-1 max-w-xl">
                            @if($filme->generos->isNotEmpty())
                                <div class="flex flex-wrap gap-2 mb-3">
                                    @foreach($filme->generos->take(3) as $genero)
                                        <span class="text-xs px-2 py-0.5 rounded bg-amber-400/10 text-amber-400 border border-amber-400/20">
                                            {{ $genero->nome }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <h2 class="text-3xl sm:text-4xl font-bold mb-3 leading-tight">
                                <a href="{{ route('filmes.show', $filme) }}" class="hover:text-amber-400 transition">
                                    {{ $filme->nome }}
                                </a>
                            </h2>

                            <div class="flex items-center gap-4 text-zinc-400 text-sm mb-4">
                                @if($filme->data_lancamento)
                                    <span>{{ $filme->data_lancamento->format('Y') }}</span>
                                @endif
                                @if($filme->duracao)
                                    <span>{{ $filme->duracao }} min</span>
                                @endif
                                @if($filme->classificacao)
                                    <span class="px-1.5 py-0.5 border border-zinc-600 rounded text-xs">{{ $filme->classificacao }}</span>
                                @endif
                                @if($filme->avaliacoes_avg_nota !== null)
                                    <span class="flex items-center gap-1 text-amber-400 font-semibold">
                                        ★ {{ number_format($filme->avaliacoes_avg_nota, 1) }}<span class="text-zinc-500 font-normal">/10</span>
                                    </span>
                                @endif
                            </div>

                            @if($filme->sinopse)
                                <p class="text-zinc-300 text-sm leading-relaxed line-clamp-4">{{ $filme->sinopse }}</p>
                            @endif

                            <a href="{{ route('filmes.show', $filme) }}"
                               class="inline-block mt-5 px-6 py-2.5 bg-amber-400 text-zinc-900 font-semibold rounded-lg hover:bg-amber-300 transition text-sm">
                                Ver detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Botão anterior --}}
            <button @click="prev()"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-zinc-900/80 border border-zinc-700 rounded-full flex items-center justify-center hover:bg-zinc-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            {{-- Botão próximo --}}
            <button @click="next()"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-zinc-900/80 border border-zinc-700 rounded-full flex items-center justify-center hover:bg-zinc-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Indicadores --}}
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                @foreach($filmesCarousel as $i => $__)
                    <button @click="current = {{ $i }}"
                            :class="current === {{ $i }} ? 'bg-amber-400 w-6' : 'bg-zinc-600 w-2'"
                            class="h-2 rounded-full transition-all duration-300">
                    </button>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ======= CARDS DE FILMES ======= --}}
        @if($filmes->isNotEmpty())
        <section class="py-14 border-t border-zinc-800">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-xl font-bold mb-8">
                    <span class="text-amber-400">|</span> Filmes
                </h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    @foreach($filmes as $filme)
                        <a href="{{ route('filmes.show', $filme) }}"
                           class="group bg-zinc-900 border border-zinc-800 rounded-xl overflow-hidden hover:border-zinc-600 hover:shadow-lg transition">
                            {{-- Imagem --}}
                            <div class="aspect-[2/3] overflow-hidden bg-zinc-800">
                                @if($filme->imagens->isNotEmpty())
                                    <img src="{{ asset('storage/' . $filme->imagens->first()->caminho) }}"
                                         alt="{{ $filme->nome }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-zinc-600">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="p-3">
                                <p class="font-semibold text-sm text-white leading-tight line-clamp-2">{{ $filme->nome }}</p>
                                @if($filme->sinopse)
                                    <p class="text-zinc-500 text-xs mt-1 line-clamp-2">{{ $filme->sinopse }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-2">
                                    @if($filme->data_lancamento)
                                        <span class="text-zinc-600 text-xs">{{ $filme->data_lancamento->format('Y') }}</span>
                                    @endif
                                    @if($filme->avaliacoes_avg_nota !== null)
                                        <span class="text-amber-400 text-xs font-semibold">
                                            ★ {{ number_format($filme->avaliacoes_avg_nota, 1) }}
                                        </span>
                                    @else
                                        <span class="text-zinc-700 text-xs">Sem nota</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- ======= CAROUSEL DE AVALIAÇÕES ======= --}}
        @if($avaliacoes->isNotEmpty())
        @php $chunks = $avaliacoes->chunk(3); @endphp
        <section class="py-14 border-t border-zinc-800 bg-zinc-900/40">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-xl font-bold mb-8">
                    <span class="text-amber-400">|</span> Últimas Avaliações
                </h2>

                <div
                    x-data="{ current: 0, total: {{ $chunks->count() }} }"
                    class="relative"
                >
                    @foreach($chunks as $ci => $grupo)
                        <div x-show="current === {{ $ci }}"
                             x-transition:enter="transition-opacity duration-500"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-300"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach($grupo as $avaliacao)
                                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-5 flex flex-col gap-3">
                                    {{-- Cabeçalho: poster + nome do filme --}}
                                    <a href="{{ route('filmes.show', $avaliacao->filme) }}"
                                       class="flex items-center gap-3 hover:opacity-80 transition">
                                        @if($avaliacao->filme->imagens->isNotEmpty())
                                            <img src="{{ asset('storage/' . $avaliacao->filme->imagens->first()->caminho) }}"
                                                 alt="{{ $avaliacao->filme->nome }}"
                                                 class="w-10 h-14 object-cover rounded border border-zinc-700 shrink-0">
                                        @else
                                            <div class="w-10 h-14 bg-zinc-800 rounded border border-zinc-700 shrink-0"></div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-xs text-zinc-500">Avaliação de</p>
                                            <p class="text-sm font-semibold text-white truncate">{{ $avaliacao->filme->nome }}</p>
                                        </div>
                                    </a>

                                    {{-- Nota --}}
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-bold text-amber-400">{{ $avaliacao->nota }}</span>
                                        <span class="text-zinc-500 text-sm">/10</span>
                                        <div class="flex-1 h-1.5 bg-zinc-800 rounded-full overflow-hidden ml-1">
                                            <div class="h-full bg-amber-400 rounded-full"
                                                 style="width: {{ ($avaliacao->nota / 10) * 100 }}%"></div>
                                        </div>
                                    </div>

                                    {{-- Título e comentário --}}
                                    @if($avaliacao->titulo)
                                        <p class="text-sm font-semibold text-white">{{ $avaliacao->titulo }}</p>
                                    @endif
                                    @if($avaliacao->descricao)
                                        <p class="text-zinc-400 text-xs leading-relaxed line-clamp-3">{{ $avaliacao->descricao }}</p>
                                    @endif

                                    {{-- Autor --}}
                                    <div class="mt-auto pt-2 border-t border-zinc-800 flex items-center justify-between">
                                        <span class="text-zinc-500 text-xs">{{ $avaliacao->user?->name ?? 'Anônimo' }}</span>
                                        <span class="text-zinc-700 text-xs">{{ $avaliacao->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    {{-- Navegação --}}
                    @if($chunks->count() > 1)
                        <div class="flex items-center justify-center gap-4 mt-8">
                            <button @click="current = (current - 1 + total) % total"
                                    class="w-9 h-9 bg-zinc-800 border border-zinc-700 rounded-full flex items-center justify-center hover:bg-zinc-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>

                            <div class="flex gap-2">
                                @foreach($chunks as $ci => $__)
                                    <button @click="current = {{ $ci }}"
                                            :class="current === {{ $ci }} ? 'bg-amber-400 w-6' : 'bg-zinc-600 w-2'"
                                            class="h-2 rounded-full transition-all duration-300">
                                    </button>
                                @endforeach
                            </div>

                            <button @click="current = (current + 1) % total"
                                    class="w-9 h-9 bg-zinc-800 border border-zinc-700 rounded-full flex items-center justify-center hover:bg-zinc-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        {{-- Mensagem quando não há conteúdo --}}
        @if($filmesCarousel->isEmpty() && $filmes->isEmpty())
        <section class="min-h-[60vh] flex items-center justify-center">
            <div class="text-center">
                <p class="text-zinc-500 text-lg mb-2">Nenhum filme cadastrado ainda.</p>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.filmes.create') }}"
                           class="text-amber-400 hover:text-amber-300 text-sm transition">
                            Adicionar primeiro filme →
                        </a>
                    @endif
                @endauth
            </div>
        </section>
        @endif

    </main>

    {{-- Rodapé simples --}}
    <footer class="border-t border-zinc-800 py-6 text-center">
        <p class="text-zinc-600 text-xs">CineApp &copy; {{ date('Y') }}</p>
    </footer>

</body>
</html>
