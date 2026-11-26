<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="viveiro-eyebrow">VISÃO GERAL</p>
            <h1 class="viveiro-heading">Painel de monitoramento</h1>
            <p class="viveiro-subheading">Acompanhe a saúde dos seus tanques em tempo real.</p>
        </div>
    </x-slot>

    <section class="viveiro-stat-grid" aria-label="Resumo dos tanques">
        <article class="viveiro-stat-card">
            <span class="viveiro-stat-icon">◉</span>
            <p>Tanques normais</p>
            <strong>{{ str_pad($contagens['normal'], 2, '0', STR_PAD_LEFT) }}</strong>
        </article>
        <article class="viveiro-stat-card is-warning">
            <span class="viveiro-stat-icon">⌁</span>
            <p>Em atenção</p>
            <strong>{{ str_pad($contagens['atencao'], 2, '0', STR_PAD_LEFT) }}</strong>
        </article>
        <article class="viveiro-stat-card is-critical">
            <span class="viveiro-stat-icon">!</span>
            <p>Críticos</p>
            <strong>{{ str_pad($contagens['critico'], 2, '0', STR_PAD_LEFT) }}</strong>
        </article>
    </section>

    <div class="viveiro-section-heading">
        <div>
            <h2>Seus tanques</h2>
            <p>Temperatura e situação atual de cada viveiro.</p>
        </div>
        <a class="viveiro-button viveiro-button-primary" href="{{ route('tanques.create') }}">+ Cadastrar novo tanque</a>
    </div>

    @if (session('status'))
        <p class="viveiro-success" role="status">{{ session('status') }}</p>
    @endif

    @if ($tanques->isNotEmpty())
        <section class="viveiro-tank-grid" aria-label="Tanques cadastrados">
            @foreach ($tanques as $tanque)
                @php($sensor = $tanque->sensores->first())
                @php($status = $sensor?->statusTemperatura() ?? 'sem-leitura')
                <a class="viveiro-tank-card status-{{ $status }}" data-tanque="{{ $tanque->id_tanque }}" href="{{ route('tanques.show', $tanque->id_tanque) }}">
                    <div class="viveiro-tank-card-top">
                        <span class="viveiro-tank-name">{{ $tanque->nome ?: 'Tanque '.$loop->iteration }}</span>
                        <span class="viveiro-status status-{{ $status }}" data-status>
                            {{ ['normal' => 'Normal', 'atencao' => 'Atenção', 'critico' => 'Crítico', 'sem-leitura' => 'Sem leitura'][$status] }}
                        </span>
                    </div>
                    <p class="viveiro-temperature" data-temperatura>
                        {{ $sensor?->temperatura_real !== null ? number_format($sensor->temperatura_real, 1, ',', '.') : '—' }}<span>°C</span>
                    </p>
                    <p class="viveiro-tank-meta" data-atualizado>
                        @if ($tanque->especie)
                            {{ $tanque->especie }} ·
                        @endif
                        @if ($sensor?->temperatura_real !== null)
                            Atualizado {{ $sensor->updated_at?->diffForHumans() ?? 'agora' }}
                        @else
                            Aguardando primeira leitura
                        @endif
                    </p>
                    <span class="viveiro-card-link">Ver detalhes <span aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </section>
    @else
        <div class="viveiro-empty-state">
            <span class="viveiro-empty-icon">◉</span>
            <h2>Nenhum tanque cadastrado</h2>
            <p>Cadastre seu primeiro tanque para acompanhar a temperatura e os alertas por aqui.</p>
            <a class="viveiro-button viveiro-button-primary" href="{{ route('tanques.create') }}">Cadastrar tanque</a>
        </div>
    @endif

    <section class="viveiro-quick-actions" aria-label="Ações rápidas">
        <a href="{{ route('alertas.index') }}"><span>⚠</span><strong>Verificar alertas</strong><small>Confira tanques que precisam de atenção</small></a>
        <a href="{{ route('alimentacoes.index') }}"><span>⌁</span><strong>Registrar arraçoamento</strong><small>Salve a alimentação do dia</small></a>
        <a href="{{ route('mortalidades.index') }}"><span>＋</span><strong>Registrar mortalidade</strong><small>Mantenha os registros atualizados</small></a>
        <a href="{{ route('relatorios.index') }}"><span>▤</span><strong>Ver relatórios</strong><small>Acompanhe os registros recentes</small></a>
    </section>

    <script>
        const statusLabels = {
            normal: 'Normal',
            atencao: 'Atenção',
            critico: 'Crítico',
            'sem-leitura': 'Sem leitura'
        };

        async function atualizarPainel() {
            try {
                const resposta = await fetch(@json(route('dashboard.dados')), {
                    headers: { Accept: 'application/json' }
                });

                if (!resposta.ok) {
                    throw new Error('Não foi possível atualizar as leituras dos tanques.');
                }

                const { tanques } = await resposta.json();
                const totais = { normal: 0, atencao: 0, critico: 0 };

                tanques.forEach(tanque => {
                    if (totais[tanque.status] !== undefined) totais[tanque.status]++;

                    const cartao = document.querySelector(`[data-tanque="${tanque.id}"]`);
                    if (!cartao) return;

                    const temperatura = cartao.querySelector('[data-temperatura]');
                    temperatura.replaceChildren();
                    temperatura.append(
                        document.createTextNode(tanque.temperatura === null
                            ? '—'
                            : Number(tanque.temperatura).toLocaleString('pt-BR', { minimumFractionDigits: 1, maximumFractionDigits: 1 }))
                    );
                    const unidade = document.createElement('span');
                    unidade.textContent = '°C';
                    temperatura.append(unidade);

                    const status = cartao.querySelector('[data-status]');
                    status.className = `viveiro-status status-${tanque.status}`;
                    status.textContent = statusLabels[tanque.status];
                    cartao.className = `viveiro-tank-card status-${tanque.status}`;
                    cartao.querySelector('[data-atualizado]').textContent = tanque.temperatura === null
                        ? 'Aguardando primeira leitura'
                        : `Atualizado ${tanque.atualizado_em}`;
                });

                document.querySelectorAll('.viveiro-stat-card strong').forEach((elemento, indice) => {
                    const estado = ['normal', 'atencao', 'critico'][indice];
                    elemento.textContent = String(totais[estado] ?? 0).padStart(2, '0');
                });
            } catch (erro) {
                console.error('Erro ao atualizar o painel:', erro);
            }
        }

        window.setInterval(atualizarPainel, 5000);
    </script>
</x-app-layout>
