<x-app-layout>
    <x-slot name="header">
        <div><p class="viveiro-eyebrow">MONITORAMENTO</p><h1 class="viveiro-heading">Alertas</h1><p class="viveiro-subheading">Tanques com temperatura fora da faixa ideal configurada.</p></div>
    </x-slot>

    @if ($tanques->isNotEmpty())
        <section class="viveiro-alert-list">
            @foreach ($tanques as $tanque)
                @php($sensor = $tanque->sensores->first())
                @php($status = $sensor?->statusTemperatura() ?? 'sem-leitura')
                <article class="viveiro-alert-card status-{{ $status }}">
                    <span class="viveiro-alert-icon">{{ $status === 'critico' ? '!' : '⚠' }}</span>
                    <div>
                        <span class="viveiro-status status-{{ $status }}">{{ $status === 'critico' ? 'Crítico' : ($status === 'atencao' ? 'Atenção' : 'Sem leitura') }}</span>
                        <h2>{{ $tanque->nome ?: 'Tanque '.$tanque->id_tanque }}</h2>
                        @if ($sensor?->temperatura_real !== null)
                            <p>Temperatura {{ number_format($sensor->temperatura_real, 1, ',', '.') }}°C. Faixa ideal: {{ number_format($sensor->temperatura_min_tanque, 1, ',', '.') }}°C a {{ number_format($sensor->temperatura_max_tanque, 1, ',', '.') }}°C.</p>
                        @else
                            <p>Este sensor ainda não enviou uma leitura de temperatura.</p>
                        @endif
                    </div>
                    <a class="viveiro-button viveiro-button-muted" href="{{ route('tanques.show', $tanque->id_tanque) }}">Ver tanque</a>
                </article>
            @endforeach
        </section>
    @else
        <div class="viveiro-empty-state">
            <span class="viveiro-empty-icon is-success">✓</span>
            <h2>Todos os tanques estão dentro da faixa ideal</h2>
            <p>Os alertas serão exibidos aqui quando uma leitura estiver fora dos limites definidos.</p>
            <a class="viveiro-button viveiro-button-muted" href="{{ route('tanques.index') }}">Ver tanques</a>
        </div>
    @endif
</x-app-layout>
