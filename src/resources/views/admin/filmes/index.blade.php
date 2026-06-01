<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Filmes</h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="font-medium text-gray-900">Lista de Filmes</h3>
                    <a href="{{ route('admin.filmes.create') }}"
                       class="px-4 py-2 bg-amber-400 text-zinc-900 text-sm font-medium rounded hover:bg-amber-300 transition">
                        + Novo Filme
                    </a>
                </div>

                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="text-left px-6 py-3">Nome</th>
                            <th class="text-left px-6 py-3">Duração</th>
                            <th class="text-left px-6 py-3">Lançamento</th>
                            <th class="text-left px-6 py-3">Classificação</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($filmes as $filme)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $filme->nome }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $filme->duracao ? $filme->duracao . ' min' : '—' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $filme->data_lancamento?->format('d/m/Y') ?? '—' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $filme->classificacao ?? '—' }}</td>
                                <td class="px-6 py-3 text-right space-x-2">
                                    <a href="{{ route('admin.filmes.edit', $filme) }}"
                                       class="text-blue-600 hover:underline">Editar</a>
                                    <form method="POST" action="{{ route('admin.filmes.destroy', $filme) }}"
                                          class="inline" onsubmit="return confirm('Excluir este filme?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Nenhum filme cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($filmes->hasPages())
                    <div class="px-6 py-4 border-t">{{ $filmes->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
