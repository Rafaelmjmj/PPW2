<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Painel Administrativo
        </h2>
    </x-slot>

    <div class="py-8">
        @include('admin.partials.nav')

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.filmes.index') }}"
                   class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="text-3xl mb-3">🎬</div>
                    <h3 class="font-semibold text-gray-900 text-lg">Filmes</h3>
                    <p class="text-gray-500 text-sm mt-1">Cadastrar e gerenciar filmes</p>
                </a>

                <a href="{{ route('admin.pessoas.index') }}"
                   class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="text-3xl mb-3">🎭</div>
                    <h3 class="font-semibold text-gray-900 text-lg">Pessoas</h3>
                    <p class="text-gray-500 text-sm mt-1">Atores, diretores, produtores e escritores</p>
                </a>

                <a href="{{ route('admin.generos.index') }}"
                   class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="text-3xl mb-3">🏷️</div>
                    <h3 class="font-semibold text-gray-900 text-lg">Gêneros</h3>
                    <p class="text-gray-500 text-sm mt-1">Gêneros cinematográficos</p>
                </a>

                <a href="{{ route('admin.estudios.index') }}"
                   class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                    <div class="text-3xl mb-3">🏢</div>
                    <h3 class="font-semibold text-gray-900 text-lg">Estúdios</h3>
                    <p class="text-gray-500 text-sm mt-1">Produtoras e estúdios</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
