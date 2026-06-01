<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Estúdio</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 text-red-700 rounded text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.estudios.update', $estudio) }}">
                    @csrf @method('PATCH')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" value="{{ old('nome', $estudio->nome) }}"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Local</label>
                        <input type="text" name="local" value="{{ old('local', $estudio->local) }}"
                               placeholder="Cidade, País"
                               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-amber-400">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-5 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                            Atualizar
                        </button>
                        <a href="{{ route('admin.estudios.index') }}"
                           class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
