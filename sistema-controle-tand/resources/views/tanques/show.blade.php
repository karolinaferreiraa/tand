<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="viveiro-eyebrow"><a href="{{ route('tanques.index') }}">TANQUES</a> / DETALHES</p>
            <h1 class="viveiro-heading">{{ $tanque->nome ?: 'Tanque '.$tanque->id_tanque }}</h1>
            <p class="viveiro-subheading">Acompanhe a temperatura e os registros deste tanque.</p>
        </div>
        <span class="viveiro-status status-{{ $sensor?->statusTemperatura() ?? 'sem-leitura' }}">
            {{ ['normal' => 'Normal', 'atencao' => 'Abaixo/acima do ideal', 'critico' => 'Crítico', 'sem-leitura' => 'Sem leitura'][$sensor?->statusTemperatura() ?? 'sem-leitura'] }}
        </span>
    </x-slot>

    <section class="viveiro-detail-grid">
        <article class="viveiro-temperature-panel">
            <p>Temperatura atual</p>
            <strong>{{ $sensor?->temperatura_real !== null ? number_format($sensor->temperatura_real, 1, ',', '.') : '—' }}<span>°C</span></strong>
            <p>Faixa ideal configurada:
                {{ $sensor ? number_format($sensor->temperatura_min_tanque, 0, ',', '.') : '—' }}°C –
                {{ $sensor ? number_format($sensor->temperatura_max_tanque, 0, ',', '.') : '—' }}°C
            </p>
        </article>
        <article class="viveiro-detail-card"><span>Mínima hoje</span><strong>{{ $estatisticas['min'] !== null ? number_format($estatisticas['min'], 1, ',', '.') : '—' }}<small>°C</small></strong></article>
        <article class="viveiro-detail-card"><span>Média hoje</span><strong>{{ $estatisticas['media'] !== null ? number_format($estatisticas['media'], 1, ',', '.') : '—' }}<small>°C</small></strong></article>
        <article class="viveiro-detail-card"><span>Máxima hoje</span><strong>{{ $estatisticas['max'] !== null ? number_format($estatisticas['max'], 1, ',', '.') : '—' }}<small>°C</small></strong></article>
    </section>

    <section class="viveiro-detail-facts">
        @if ($tanque->especie)<span><strong>Espécie</strong>{{ $tanque->especie }}</span>@endif
        @if ($tanque->dimensoes)<span><strong>Dimensões</strong>{{ $tanque->dimensoes }}</span>@endif
        @if ($tanque->volume_estimado)<span><strong>Volume estimado</strong>{{ number_format($tanque->volume_estimado, 2, ',', '.') }} m³</span>@endif
        @if ($tanque->quantidade_alevinos)<span><strong>Alevinos iniciais</strong>{{ number_format($tanque->quantidade_alevinos, 0, ',', '.') }}</span>@endif
        @if ($sensor)<span><strong>pH</strong>{{ number_format($sensor->ph_real, 1, ',', '.') }}</span>@endif
    </section>

    <div class="viveiro-section-heading">
        <div><h2>Eventos recentes</h2><p>Últimos registros associados a este tanque.</p></div>
        <div class="viveiro-inline-actions">
            <a class="viveiro-button viveiro-button-muted" href="{{ route('alimentacoes.index', ['tanque' => $tanque->id_tanque]) }}">Registrar arraçoamento</a>
            <a class="viveiro-button viveiro-button-primary" href="{{ route('mortalidades.index', ['tanque' => $tanque->id_tanque]) }}">Registrar mortalidade</a>
        </div>
    </div>
    <div class="viveiro-table-wrap">
        <table class="viveiro-table">
            <thead><tr><th>Evento</th><th>Data e horário</th></tr></thead>
            <tbody>
                @forelse ($eventos as $evento)
                    <tr><td>{{ $evento['descricao'] }}</td><td>{{ $evento['data']->format('d/m/Y H:i') }}</td></tr>
                @empty
                    <tr><td colspan="2" class="viveiro-table-empty">Ainda não há eventos registrados para este tanque.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
