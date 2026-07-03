<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $filme->nome }} — CineApp</title>
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

        {{-- Hero do Filme --}}
        <section class="border-b border-zinc-800 pb-10 mb-10">
            <div class="max-w-5xl mx-auto px-6">
                <div class="flex flex-col sm:flex-row gap-8 pt-6">

                    {{-- Imagem principal --}}
                    <div class="shrink-0">
                        @if($filme->imagens->isNotEmpty())
                            <img src="{{ asset('storage/' . $filme->imagens->first()->caminho) }}"
                                 alt="{{ $filme->nome }}"
                                 class="w-48 h-72 object-cover rounded-lg border border-zinc-700 shadow-xl">
                        @else
                            <div class="w-48 h-72 rounded-lg border border-zinc-700 bg-zinc-800 flex items-center justify-center text-zinc-500 text-sm">
                                Sem imagem
                            </div>
                        @endif
                    </div>

                    {{-- Dados principais --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($filme->generos as $genero)
                                <span class="text-xs px-2 py-1 rounded bg-amber-400/10 text-amber-400 border border-amber-400/20">
                                    {{ $genero->nome }}
                                </span>
                            @endforeach
                        </div>

                        <h1 class="text-3xl sm:text-4xl font-bold mb-2">{{ $filme->nome }}</h1>

                        <div class="flex flex-wrap items-center gap-4 text-zinc-400 text-sm mb-5">
                            @if($filme->data_lancamento)
                                <span>{{ $filme->data_lancamento->format('Y') }}</span>
                            @endif
                            @if($filme->duracao)
                                <span>{{ $filme->duracao }} min</span>
                            @endif
                            @if($filme->classificacao)
                                <span class="px-2 py-0.5 border border-zinc-600 rounded text-xs">{{ $filme->classificacao }}</span>
                            @endif
                        </div>

                        @if($filme->sinopse)
                            <p class="text-zinc-300 text-sm leading-relaxed max-w-2xl">{{ $filme->sinopse }}</p>
                        @endif

                        @if($filme->estudios->isNotEmpty())
                            <div class="mt-5">
                                <p class="text-xs text-zinc-500 uppercase tracking-widest mb-1">Produção</p>
                                <p class="text-sm text-zinc-300">{{ $filme->estudios->pluck('nome')->join(', ') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="max-w-5xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Coluna principal --}}
                <div class="lg:col-span-2 space-y-10">

                    {{-- Elenco --}}
                    @if($filme->atores->isNotEmpty())
                        <section>
                            <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Elenco</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($filme->atores as $ator)
                                    <a href="{{ route('pessoas.show', $ator->pessoa) }}"
                                       class="bg-zinc-900 border border-zinc-800 rounded-lg p-3 hover:border-zinc-600 transition">
                                        <p class="font-medium text-white text-sm">{{ $ator->pessoa->nome }}</p>
                                        @if($ator->pivot->papel)
                                            <p class="text-zinc-500 text-xs mt-1">{{ $ator->pivot->papel }}</p>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Direção --}}
                    @if($filme->diretores->isNotEmpty())
                        <section>
                            <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Direção</h2>
                            <div class="flex flex-wrap gap-3">
                                @foreach($filme->diretores as $diretor)
                                    <a href="{{ route('pessoas.show', $diretor->pessoa) }}"
                                       class="bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-2 text-sm text-white hover:border-zinc-600 transition">
                                        {{ $diretor->pessoa->nome }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Roteiro --}}
                    @if($filme->escritores->isNotEmpty())
                        <section>
                            <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Roteiro</h2>
                            <div class="flex flex-wrap gap-3">
                                @foreach($filme->escritores as $escritor)
                                    <a href="{{ route('pessoas.show', $escritor->pessoa) }}"
                                       class="bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-2 text-sm text-white hover:border-zinc-600 transition">
                                        {{ $escritor->pessoa->nome }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Produção --}}
                    @if($filme->produtores->isNotEmpty())
                        <section>
                            <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Produção</h2>
                            <div class="flex flex-wrap gap-3">
                                @foreach($filme->produtores as $produtor)
                                    <a href="{{ route('pessoas.show', $produtor->pessoa) }}"
                                       class="bg-zinc-900 border border-zinc-800 rounded-lg px-4 py-2 text-sm text-white hover:border-zinc-600 transition">
                                        {{ $produtor->pessoa->nome }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Galeria de imagens --}}
                    @if($filme->imagens->count() > 1)
                        <section>
                            <h2 class="text-amber-400 text-xs font-semibold uppercase tracking-widest mb-4">Galeria</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach($filme->imagens->skip(1) as $imagem)
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
                        @if($filme->data_lancamento)
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-1">Lançamento</p>
                                <p class="text-white">{{ $filme->data_lancamento->format('d/m/Y') }}</p>
                            </div>
                        @endif
                        @if($filme->duracao)
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-1">Duração</p>
                                <p class="text-white">{{ $filme->duracao }} minutos</p>
                            </div>
                        @endif
                        @if($filme->classificacao)
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-1">Classificação</p>
                                <p class="text-white">{{ $filme->classificacao }}</p>
                            </div>
                        @endif
                        @if($filme->generos->isNotEmpty())
                            <div>
                                <p class="text-zinc-500 text-xs uppercase tracking-widest mb-2">Gêneros</p>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($filme->generos as $genero)
                                        <span class="px-2 py-0.5 text-xs bg-zinc-800 text-zinc-300 rounded">{{ $genero->nome }}</span>
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

        {{-- Avaliações --}}
        <div class="max-w-5xl mx-auto px-6 mt-16 border-t border-zinc-800 pt-12">

            <h2 class="text-xl font-bold mb-8">Avaliações
                <span class="text-zinc-500 text-sm font-normal ml-2">({{ $filme->avaliacoes->count() }})</span>
            </h2>

            {{-- Formulário --}}
            @auth
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-900/40 border border-green-700 text-green-300 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 mb-10">
                    <h3 class="text-sm font-semibold text-zinc-300 mb-4">Deixe sua avaliação</h3>

                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-900/40 border border-red-700 text-red-300 rounded text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('filmes.avaliacoes.store', $filme) }}">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs text-zinc-400 mb-1">Título <span class="text-red-400">*</span></label>
                                <input type="text" name="titulo" value="{{ old('titulo') }}"
                                       placeholder="Resuma sua opinião"
                                       class="w-full bg-zinc-800 border border-zinc-700 rounded-lg px-3 py-2 text-white placeholder-zinc-500 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-xs text-zinc-400 mb-1">Nota (0–10) <span class="text-red-400">*</span></label>
                                <input type="number" name="nota" value="{{ old('nota') }}"
                                       min="0" max="10" step="1"
                                       placeholder="Ex: 8"
                                       class="w-full bg-zinc-800 border border-zinc-700 rounded-lg px-3 py-2 text-white placeholder-zinc-500 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs text-zinc-400 mb-1">Comentário</label>
                            <textarea name="descricao" rows="3"
                                      placeholder="Conte mais sobre o que achou do filme..."
                                      class="w-full bg-zinc-800 border border-zinc-700 rounded-lg px-3 py-2 text-white placeholder-zinc-500 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent resize-none">{{ old('descricao') }}</textarea>
                        </div>
                        <button type="submit"
                                class="px-6 py-2 bg-amber-400 text-zinc-900 font-semibold rounded-lg hover:bg-amber-300 transition text-sm">
                            Enviar avaliação
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 mb-10 text-center">
                    <p class="text-zinc-400 text-sm">
                        <a href="{{ route('login') }}" class="text-amber-400 hover:underline">Faça login</a>
                        para deixar sua avaliação.
                    </p>
                </div>
            @endauth

            {{-- Lista de avaliações --}}
            @if($filme->avaliacoes->isEmpty())
                <p class="text-zinc-500 text-sm text-center py-8">Nenhuma avaliação ainda. Seja o primeiro a avaliar!</p>
            @else
                <div class="space-y-4">
                    @foreach($filme->avaliacoes->sortByDesc('created_at') as $avaliacao)
                        <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-5">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-semibold text-white">
                                        {{ $avaliacao->user->name ?? 'Usuário' }}
                                    </span>
                                    <span class="text-xs text-zinc-500">
                                        {{ $avaliacao->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                                <span class="px-3 py-1 bg-amber-400/10 border border-amber-400/30 text-amber-400 text-sm font-bold rounded-full">
                                    {{ $avaliacao->nota }}<span class="text-xs font-normal text-amber-400/60">/10</span>
                                </span>
                            </div>
                            @if($avaliacao->titulo)
                                <p class="text-white font-medium text-sm mb-1">{{ $avaliacao->titulo }}</p>
                            @endif
                            @if($avaliacao->descricao)
                                <p class="text-zinc-400 text-sm leading-relaxed">{{ $avaliacao->descricao }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </main>

</body>
</html>

