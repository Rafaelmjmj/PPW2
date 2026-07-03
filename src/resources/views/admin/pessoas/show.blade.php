<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Visualizar Pessoa</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $pessoa->nome }}</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.pessoas.edit', $pessoa) }}"
                           class="px-4 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                            Editar
                        </a>
                        <a href="{{ route('admin.pessoas.index') }}"
                           class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition">
                            Voltar
                        </a>
                    </div>
                </div>

                {{-- Imagens --}}
                @if($pessoa->imagens->isNotEmpty())
                    <div class="mb-6">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Fotos</p>
                        <div class="flex flex-wrap gap-3">
                            @foreach($pessoa->imagens as $imagem)
                                <img src="{{ asset('storage/' . $imagem->caminho) }}"
                                     alt="{{ $imagem->nome }}"
                                     class="h-32 w-auto rounded border border-gray-200 object-cover">
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Dados pessoais --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Data de Nascimento</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $pessoa->data_nascimento?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Gênero</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $pessoa->genero ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nacionalidade</p>
                        <p class="text-sm text-gray-800 mt-1">{{ $pessoa->nacionalidade ?? '—' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Biografia</p>
                        <p class="text-sm text-gray-800 mt-1 leading-relaxed">{{ $pessoa->biografia ?? '—' }}</p>
                    </div>
                </div>

                {{-- Papéis --}}
                <div class="mb-4 border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Papéis</p>
                    @php
                        $papeis = [];
                        if ($pessoa->ator)    $papeis[] = 'Ator';
                        if ($pessoa->diretor) $papeis[] = 'Diretor';
                        if ($pessoa->produtor)$papeis[] = 'Produtor';
                        if ($pessoa->escritor)$papeis[] = 'Escritor';
                    @endphp
                    @if(count($papeis))
                        <div class="flex flex-wrap gap-2">
                            @foreach($papeis as $papel)
                                <span class="px-2 py-1 bg-amber-50 text-amber-700 text-xs rounded">{{ $papel }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400">Nenhum papel atribuído.</p>
                    @endif
                </div>

                {{-- Filmes vinculados --}}
                @php
                    $filmesVinculados = collect();
                    if ($pessoa->ator)    $filmesVinculados = $filmesVinculados->merge($pessoa->ator->filmes);
                    if ($pessoa->diretor) $filmesVinculados = $filmesVinculados->merge($pessoa->diretor->filmes);
                    if ($pessoa->produtor)$filmesVinculados = $filmesVinculados->merge($pessoa->produtor->filmes);
                    if ($pessoa->escritor)$filmesVinculados = $filmesVinculados->merge($pessoa->escritor->filmes);
                    $filmesUnicos = $filmesVinculados->unique('id')->sortBy('nome');
                @endphp
                <div class="border-t pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Filmes Vinculados</p>
                    @if($filmesUnicos->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach($filmesUnicos as $filme)
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                                    {{ $filme->nome }}
                                    @if($filme->data_lancamento)
                                        ({{ $filme->data_lancamento->format('Y') }})
                                    @endif
                                </span>
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
