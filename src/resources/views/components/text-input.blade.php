@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-zinc-800 border-zinc-700 text-white placeholder-zinc-500 focus:border-amber-400 focus:ring-amber-400 rounded-lg shadow-sm']) }}>
