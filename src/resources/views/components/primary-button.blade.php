<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-amber-400 border border-transparent rounded-lg font-semibold text-sm text-zinc-900 uppercase tracking-widest hover:bg-amber-300 focus:bg-amber-300 active:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 focus:ring-offset-zinc-900 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
