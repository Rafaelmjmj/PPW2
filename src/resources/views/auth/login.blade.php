<x-guest-layout>
    <h2 class="text-xl font-semibold text-white mb-6">Entrar na sua conta</h2>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                          name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-zinc-600 bg-zinc-800 text-amber-400 shadow-sm focus:ring-amber-400"
                       name="remember">
                <span class="ms-2 text-sm text-zinc-400">Lembrar de mim</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-zinc-400 hover:text-amber-400 transition"
                   href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
            @endif

            <x-primary-button>
                Entrar
            </x-primary-button>
        </div>

        <p class="mt-6 text-center text-sm text-zinc-500">
            Não tem conta?
            <a href="{{ route('register') }}" class="text-amber-400 hover:text-amber-300 transition font-medium">
                Criar conta
            </a>
        </p>
    </form>
</x-guest-layout>
