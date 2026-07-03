<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Pessoa</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $papeisAtuais = [];
                    if ($pessoa->ator)    $papeisAtuais[] = 'ator';
                    if ($pessoa->diretor) $papeisAtuais[] = 'diretor';
                    if ($pessoa->produtor)$papeisAtuais[] = 'produtor';
                    if ($pessoa->escritor)$papeisAtuais[] = 'escritor';
                @endphp

                <form method="POST" action="{{ route('admin.pessoas.update', $pessoa) }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')

                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Dados da Pessoa</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                            <input type="text" name="nome" value="{{ old('nome', $pessoa->nome) }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Data de Nascimento</label>
                            <input type="date" name="data_nascimento"
                                   value="{{ old('data_nascimento', $pessoa->data_nascimento?->format('Y-m-d')) }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                            <select name="genero"
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                                <option value="">Selecione...</option>
                                <option value="Masculino" @selected(old('genero', $pessoa->genero) === 'Masculino')>Masculino</option>
                                <option value="Feminino"  @selected(old('genero', $pessoa->genero) === 'Feminino')>Feminino</option>
                                <option value="Outro"     @selected(old('genero', $pessoa->genero) === 'Outro')>Outro</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nacionalidade</label>
                            <input type="text" name="nacionalidade" value="{{ old('nacionalidade', $pessoa->nacionalidade) }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Biografia</label>
                            <textarea name="biografia" rows="4"
                                      class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">{{ old('biografia', $pessoa->biografia) }}</textarea>
                        </div>
                    </div>

                    {{-- Imagens --}}
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Imagens</h3>
                    @if($pessoa->imagens->isNotEmpty())
                        <p class="text-xs text-gray-500 mb-2">Marque as imagens que deseja remover:</p>
                        <div class="grid grid-cols-3 sm:grid-cols-5 gap-3 mb-4">
                            @foreach($pessoa->imagens as $imagem)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $imagem->caminho) }}"
                                         alt="{{ $imagem->nome }}"
                                         class="w-full h-20 object-cover rounded border border-gray-200 mb-1">
                                    <label class="flex items-center justify-center gap-1 text-xs text-red-600 cursor-pointer">
                                        <input type="checkbox" name="deletar_imagens[]" value="{{ $imagem->id }}"
                                               class="rounded border-gray-300 text-red-500 focus:ring-red-400">
                                        Remover
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Adicionar novas imagens</label>
                        <input type="file" name="imagens[]" multiple accept="image/*"
                               class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-1">Máximo 5MB por imagem.</p>
                    </div>

                    {{-- Papéis --}}
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Papéis</h3>
                    <div class="flex flex-wrap gap-4 mb-6">
                        @foreach(['ator' => 'Ator', 'diretor' => 'Diretor', 'produtor' => 'Produtor', 'escritor' => 'Escritor'] as $valor => $label)
                            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                <input type="checkbox" name="papeis[]" value="{{ $valor }}"
                                       {{ in_array($valor, old('papeis', $papeisAtuais)) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>

                    {{-- Filmes --}}
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3 border-t pt-4">Filmes Vinculados</h3>
                    @if($filmes->isEmpty())
                        <p class="text-sm text-gray-400 mb-6">Nenhum filme cadastrado ainda.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6 max-h-60 overflow-y-auto border border-gray-200 rounded p-3">
                            @foreach($filmes as $filme)
                                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filmes[]" value="{{ $filme->id }}"
                                           {{ in_array($filme->id, old('filmes', $filmesIds)) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                    {{ $filme->nome }}
                                    @if($filme->data_lancamento)
                                        <span class="text-gray-400 text-xs">({{ $filme->data_lancamento->format('Y') }})</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex gap-3 border-t pt-4">
                        <button type="submit"
                                class="px-5 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                            Atualizar
                        </button>
                        <a href="{{ route('admin.pessoas.show', $pessoa) }}"
                           class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
