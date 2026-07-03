<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Visualizar Filme</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $filme->nome }}</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.filmes.edit', $filme) }}"
                           class="px-4 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                            Editar
                        </a>
                        <a href="{{ route('admin.filmes.index') }}"
                           class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition">
                            Voltar
                        </a>
                    </div>
                </div>

                {{-- Imagens --}}
                @if($filme->imagens->isNotEmpty())
                    <div class="mb-6">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Imagens</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach($filme->imagens as $imagem)
                                <img src="{{ asset('storage/' . $imagem->caminho) }}"
                                     alt="{{ $imagem->nome }}"
                                     class="h-32 w-auto rounded border border-gray-200 object-cover">
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Dados principais --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Duração</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $filme->duracao ? $filme->duracao . ' min' : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Data de Lançamento</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $filme->data_lancamento?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Classificação</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $filme->classificacao ?? '—' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Sinopse</p>
                        <p class="text-sm text-gray-800 mt-1 leading-relaxed">{{ $filme->sinopse ?? '—' }}</p>
                    </div>
                </div>

                {{-- Gêneros --}}
                <div class="mb-4 border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Gêneros</p>
                    @if($filme->generos->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($filme->generos as $genero)
                                <span class="px-2 py-1 bg-amber-50 text-amber-700 text-xs rounded">{{ $genero->nome }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">—</p>
                    @endif
                </div>

                {{-- Estúdios --}}
                <div class="mb-4 border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Estúdios / Produtoras</p>
                    @if($filme->estudios->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($filme->estudios as $estudio)
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">{{ $estudio->nome }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">—</p>
                    @endif
                </div>

                {{-- Diretores --}}
                <div class="mb-4 border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Diretores</p>
                    @if($filme->diretores->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($filme->diretores as $diretor)
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded">{{ $diretor->pessoa->nome }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">—</p>
                    @endif
                </div>

                {{-- Produtores --}}
                <div class="mb-4 border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Produtores</p>
                    @if($filme->produtores->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($filme->produtores as $produtor)
                                <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded">{{ $produtor->pessoa->nome }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">—</p>
                    @endif
                </div>

                {{-- Escritores --}}
                <div class="mb-4 border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Escritores / Roteiristas</p>
                    @if($filme->escritores->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($filme->escritores as $escritor)
                                <span class="px-2 py-1 bg-purple-50 text-purple-700 text-xs rounded">{{ $escritor->pessoa->nome }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">—</p>
                    @endif
                </div>

                {{-- Atores --}}
                <div class="border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Elenco (Atores)</p>
                    @if($filme->atores->isNotEmpty())
                        <div class="space-y-1">
                            @foreach($filme->atores as $ator)
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="text-gray-800 font-medium">{{ $ator->pessoa->nome }}</span>
                                    @if($ator->pivot->papel)
                                        <span class="text-gray-400">— {{ $ator->pivot->papel }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">—</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
