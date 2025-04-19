<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e nós lhe enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form id="reset-form" method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <!-- Botão voltar -->
            <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                ← Voltar para o início
            </a>

            <!-- Botão enviar -->
            <x-primary-button onclick="submitAndRedirect(event)">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Script para redirecionar após submit -->
    <script>
        function submitAndRedirect(event) {
            event.preventDefault();
            const form = document.getElementById('reset-form');
            form.submit();
            // Aguarda alguns segundos para o backend processar, então redireciona
            setTimeout(() => {
                window.location.href = "/";
            }, 1000); // você pode ajustar esse tempo se quiser
        }
    </script>
</x-guest-layout>
