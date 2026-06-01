<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Pessoa</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
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

                <form method="POST" action="{{ route('admin.pessoas.update', $pessoa) }}">
                    @csrf @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                            <input type="text" name="nome" value="{{ old('nome', $pessoa->nome) }}"
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                            <input type="text" name="cpf" value="{{ old('cpf', $pessoa->cpf) }}"
                                   placeholder="000.000.000-00"
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

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Papéis</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['ator' => 'Ator', 'diretor' => 'Diretor', 'produtor' => 'Produtor', 'escritor' => 'Escritor'] as $valor => $label)
                                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="papeis[]" value="{{ $valor }}"
                                           {{ in_array($valor, old('papeis', $papeisAtuais)) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-amber-400 focus:ring-amber-400">
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-5 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                            Atualizar
                        </button>
                        <a href="{{ route('admin.pessoas.index') }}"
                           class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
