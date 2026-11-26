<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="viveiro-eyebrow">PROPRIEDADE</p>
            <h1 class="viveiro-heading">Tanques registrados</h1>
            <p class="viveiro-subheading">Monitore seus viveiros e consulte os detalhes de cada tanque.</p>
        </div>
        <a class="viveiro-button viveiro-button-primary" href="{{ route('tanques.create') }}">+ Novo tanque</a>
    </x-slot>

    @if (session('status'))
        <p class="viveiro-success" role="status">{{ session('status') }}</p>
    @endif

    <div class="viveiro-status-legend">
        <span><i class="status-normal"></i> Normal</span>
        <span><i class="status-atencao"></i> Atenção</span>
        <span><i class="status-critico"></i> Crítico</span>
        <span><i class="status-sem-leitura"></i> Sem leitura</span>
    </div>

    @if ($tanques->isNotEmpty())
        <section class="viveiro-tank-grid">
            @foreach ($tanques as $tanque)
                @php($sensor = $tanque->sensores->first())
                @php($status = $sensor?->statusTemperatura() ?? 'sem-leitura')
                <a class="viveiro-tank-card status-{{ $status }}" href="{{ route('tanques.show', $tanque->id_tanque) }}">
                    <div class="viveiro-tank-card-top">
                        <span class="viveiro-tank-name">{{ $tanque->nome ?: 'Tanque '.$loop->iteration }}</span>
                        <span class="viveiro-status status-{{ $status }}">
                            {{ ['normal' => 'Normal', 'atencao' => 'Atenção', 'critico' => 'Crítico', 'sem-leitura' => 'Sem leitura'][$status] }}
                        </span>
                    </div>
                    <p class="viveiro-temperature">
                        {{ $sensor?->temperatura_real !== null ? number_format($sensor->temperatura_real, 1, ',', '.') : '—' }}<span>°C</span>
                    </p>
                    <p class="viveiro-tank-meta">Atualizado {{ $sensor?->updated_at?->diffForHumans() ?? 'sem leitura' }}</p>
                    <span class="viveiro-card-link">Ver detalhes <span aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </section>
    @else
        <div class="viveiro-empty-state">
            <h2>Nenhum tanque registrado</h2>
            <p>Cadastre o primeiro viveiro para começar o monitoramento.</p>
            <a class="viveiro-button viveiro-button-primary" href="{{ route('tanques.create') }}">Cadastrar tanque</a>
        </div>
    @endif
</x-app-layout>
