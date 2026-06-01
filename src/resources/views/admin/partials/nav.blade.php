<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.index') }}"
           class="px-3 py-1.5 text-xs font-medium rounded {{ request()->routeIs('admin.index') ? 'bg-amber-400 text-zinc-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Painel
        </a>
        <a href="{{ route('admin.filmes.index') }}"
           class="px-3 py-1.5 text-xs font-medium rounded {{ request()->routeIs('admin.filmes.*') ? 'bg-amber-400 text-zinc-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Filmes
        </a>
        <a href="{{ route('admin.pessoas.index') }}"
           class="px-3 py-1.5 text-xs font-medium rounded {{ request()->routeIs('admin.pessoas.*') ? 'bg-amber-400 text-zinc-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Pessoas
        </a>
        <a href="{{ route('admin.generos.index') }}"
           class="px-3 py-1.5 text-xs font-medium rounded {{ request()->routeIs('admin.generos.*') ? 'bg-amber-400 text-zinc-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Gêneros
        </a>
        <a href="{{ route('admin.estudios.index') }}"
           class="px-3 py-1.5 text-xs font-medium rounded {{ request()->routeIs('admin.estudios.*') ? 'bg-amber-400 text-zinc-900' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            Estúdios
        </a>
    </div>
</div>
