<x-guest-layout>
    <div class="viveiro-split">
        <div class="viveiro-branding">
            <p class="eyebrow">SEJA BEM-VINDO!</p>
            <h1 class="logo">VIVEIRO</h1>
        </div>

        <div class="viveiro-form-side">
            <div class="viveiro-card">
                <a href="{{ route('home') }}" class="viveiro-close">&times;</a>

                <h1>Seja bem-vindo!</h1>
                <p class="subtitle">Faça login na sua conta</p>

                @if (session('status'))
                    <div class="viveiro-error" style="background:#eaf6ee; border-color:#bfe3c8; color:#1f6b3a;">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="viveiro-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="viveiro-field">
                        <label for="email">Email:</label>
                        <div class="viveiro-input-wrap">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <input id="email" type="email" name="email" placeholder="ex: joaosilva@gmail.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="viveiro-field">
                        <label for="senha">Senha:</label>
                        <div class="viveiro-input-wrap">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                            <input id="senha" type="password" name="senha" required>
                            <button type="button" class="viveiro-toggle-eye" onclick="const i=document.getElementById('senha'); i.type = i.type==='password'?'text':'password';">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="viveiro-btn">ENTRAR</button>
                </form>

                <p class="viveiro-link">Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>