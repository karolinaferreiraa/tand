<x-guest-layout>
    <div class="viveiro-split">
        <div class="viveiro-branding" style="flex:none; width:100%;">
            <p class="eyebrow">SEJA BEM-VINDO!</p>
            <h1 class="logo">VIVEIRO</h1>

            <div style="max-width:320px; width:100%; margin-top:3rem;">
                <a href="{{ route('register') }}" class="viveiro-btn viveiro-btn-outline" style="display:block; text-decoration:none; text-align:center;">
                    REGISTRE-SE
                </a>
                <p class="viveiro-link viveiro-link-light">
                    Já tem uma conta? <a href="{{ route('login') }}">Faça login</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>