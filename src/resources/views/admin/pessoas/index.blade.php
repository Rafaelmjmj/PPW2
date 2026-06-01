<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pessoas</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="font-medium text-gray-900">Lista de Pessoas</h3>
                    <a href="{{ route('admin.pessoas.create') }}"
                       class="px-4 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                        + Nova Pessoa
                    </a>
                </div>

                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="text-left px-6 py-3">Nome</th>
                            <th class="text-left px-6 py-3">Papéis</th>
                            <th class="text-left px-6 py-3">Nacionalidade</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pessoas as $pessoa)
                            @php
                                $papeis = [];
                                if ($pessoa->ator) $papeis[] = 'Ator';
                                if ($pessoa->diretor) $papeis[] = 'Diretor';
                                if ($pessoa->produtor) $papeis[] = 'Produtor';
                                if ($pessoa->escritor) $papeis[] = 'Escritor';
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $pessoa->nome }}</td>
                                <td class="px-6 py-3 text-gray-600">
                                    @if(count($papeis))
                                        <span class="text-xs">{{ implode(', ', $papeis) }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ $pessoa->nacionalidade ?? '—' }}</td>
                                <td class="px-6 py-3 text-right space-x-2">
                                    <a href="{{ route('admin.pessoas.edit', $pessoa) }}"
                                       class="text-blue-600 hover:underline">Editar</a>
                                    <form method="POST" action="{{ route('admin.pessoas.destroy', $pessoa) }}"
                                          class="inline" onsubmit="return confirm('Excluir esta pessoa?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400">Nenhuma pessoa cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($pessoas->hasPages())
                    <div class="px-6 py-4 border-t">{{ $pessoas->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
