<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Filme</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $generosIds   = $filme->generos->pluck('id')->toArray();
                    $estudiosIds  = $filme->estudios->pluck('id')->toArray();
                    $diretoresIds = $filme->diretores->pluck('id')->toArray();
                    $produtoresIds= $filme->produtores->pluck('id')->toArray();
                    $escritoresIds= $filme->escritores->pluck('id')->toArray();
                    $atoresIds    = $filme->atores->pluck('id')->toArray();
                    $atoresPapel  = $filme->atores->pluck('pivot.papel', 'id')->toArray();
                @endphp

                <form method="POST" action="{{ route('admin.filmes.update', $filme) }}">
                    @csrf @method('PATCH')

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Dados do Filme</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                            <input type="text" name="nome" value="{{ old('nome', $filme->nome) }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duração (min)</label>
                            <input type="number" name="duracao" value="{{ old('duracao', $filme->duracao) }}" min="1"
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data de Lançamento</label>
                            <input type="date" name="data_lancamento"
                                   value="{{ old('data_lancamento', $filme->data_lancamento?->format('Y-m-d')) }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Classificação</label>
                            <select name="classificacao"
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                                <option value="">Selecione...</option>
                                @foreach(['Livre', '10 anos', '12 anos', '14 anos', '16 anos', '18 anos'] as $c)
                                    <option value="{{ $c }}" @selected(old('classificacao', $filme->classificacao) === $c)>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sinopse</label>
                            <textarea name="sinopse" rows="4"
                                      class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">{{ old('sinopse', $filme->sinopse) }}</textarea>
                        </div>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Gêneros</h3>
                    <div class="flex flex-wrap gap-3 mb-6">
                        @foreach($generos as $genero)
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="generos[]" value="{{ $genero->id }}"
                                       {{ in_array($genero->id, old('generos', $generosIds)) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                {{ $genero->nome }}
                            </label>
                        @endforeach
                        @if($generos->isEmpty())<p class="text-sm text-gray-400">Nenhum gênero cadastrado.</p>@endif
                    </div>

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Estúdios / Produtoras</h3>
                    <div class="flex flex-wrap gap-3 mb-6">
                        @foreach($estudios as $estudio)
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="estudios[]" value="{{ $estudio->id }}"
                                       {{ in_array($estudio->id, old('estudios', $estudiosIds)) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                {{ $estudio->nome }}
                            </label>
                        @endforeach
                        @if($estudios->isEmpty())<p class="text-sm text-gray-400">Nenhum estúdio cadastrado.</p>@endif
                    </div>

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Diretores</h3>
                    <div class="flex flex-wrap gap-3 mb-6">
                        @foreach($diretores as $diretor)
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="diretores[]" value="{{ $diretor->id }}"
                                       {{ in_array($diretor->id, old('diretores', $diretoresIds)) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                {{ $diretor->pessoa->nome }}
                            </label>
                        @endforeach
                        @if($diretores->isEmpty())<p class="text-sm text-gray-400">Nenhum diretor cadastrado.</p>@endif
                    </div>

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Produtores</h3>
                    <div class="flex flex-wrap gap-3 mb-6">
                        @foreach($produtores as $produtor)
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="produtores[]" value="{{ $produtor->id }}"
                                       {{ in_array($produtor->id, old('produtores', $produtoresIds)) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                {{ $produtor->pessoa->nome }}
                            </label>
                        @endforeach
                        @if($produtores->isEmpty())<p class="text-sm text-gray-400">Nenhum produtor cadastrado.</p>@endif
                    </div>

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Escritores / Roteiristas</h3>
                    <div class="flex flex-wrap gap-3 mb-6">
                        @foreach($escritores as $escritor)
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="escritores[]" value="{{ $escritor->id }}"
                                       {{ in_array($escritor->id, old('escritores', $escritoresIds)) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                {{ $escritor->pessoa->nome }}
                            </label>
                        @endforeach
                        @if($escritores->isEmpty())<p class="text-sm text-gray-400">Nenhum escritor cadastrado.</p>@endif
                    </div>

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Atores</h3>
                    @if($atores->isEmpty())
                        <p class="text-sm text-gray-400 mb-6">Nenhum ator cadastrado.</p>
                    @else
                        <div class="space-y-2 mb-6">
                            @foreach($atores as $ator)
                                @php
                                    $oldDados     = old("atores.{$ator->id}", []);
                                    $selecionado  = !empty($oldDados) ? !empty($oldDados['selecionado']) : in_array($ator->id, $atoresIds);
                                    $papel        = $oldDados['papel'] ?? ($atoresPapel[$ator->id] ?? '');
                                @endphp
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="atores[{{ $ator->id }}][selecionado]" value="1"
                                           id="ator_{{ $ator->id }}"
                                           {{ $selecionado ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                    <label for="ator_{{ $ator->id }}" class="text-sm text-gray-700 w-40 cursor-pointer">
                                        {{ $ator->pessoa->nome }}
                                    </label>
                                    <input type="text" name="atores[{{ $ator->id }}][papel]"
                                           value="{{ $papel }}"
                                           placeholder="Personagem / Papel"
                                           class="flex-1 border border-gray-200 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-3 border-t pt-4">
                        <button type="submit"
                                class="px-5 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                            Atualizar Filme
                        </button>
                        <a href="{{ route('admin.filmes.index') }}"
                           class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
