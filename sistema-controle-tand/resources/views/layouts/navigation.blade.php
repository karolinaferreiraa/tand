<aside class="viveiro-sidebar">
    <a class="viveiro-sidebar-brand" href="{{ route('dashboard') }}">
        <span class="viveiro-brand-mark">V</span>
        <span>VIVEIRO</span>
    </a>

    <p class="viveiro-nav-label">GERENCIAMENTO</p>
    <nav class="viveiro-nav" aria-label="Navegação principal">
        <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>
            <span aria-hidden="true">⌂</span> Painel
        </a>
        <a href="{{ route('tanques.index') }}" @class(['active' => request()->routeIs('tanques.*')])>
            <span aria-hidden="true">◉</span> Tanques
        </a>
        <a href="{{ route('alimentacoes.index') }}" @class(['active' => request()->routeIs('alimentacoes.*')])>
            <span aria-hidden="true">⌁</span> Arraçoamento
        </a>
        <a href="{{ route('relatorios.index') }}" @class(['active' => request()->routeIs('relatorios.*')])>
            <span aria-hidden="true">▤</span> Relatórios
        </a>
        <a href="{{ route('mortalidades.index') }}" @class(['active' => request()->routeIs('mortalidades.*')])>
            <span aria-hidden="true">＋</span> Mortalidade
        </a>
        <a href="{{ route('alertas.index') }}" @class(['active' => request()->routeIs('alertas.*')])>
            <span aria-hidden="true">♧</span> Alertas
        </a>
    </nav>

    <div class="viveiro-sidebar-footer">
        <a href="{{ route('profile.edit') }}">Minha conta</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Sair da conta</button>
        </form>
    </div>
</aside>
