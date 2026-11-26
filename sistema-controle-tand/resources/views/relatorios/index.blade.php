<x-app-layout>
    <x-slot name="header">
        <div><p class="viveiro-eyebrow">HISTÓRICO</p><h1 class="viveiro-heading">Relatórios</h1><p class="viveiro-subheading">Consulte leituras e registros recentes dos seus tanques.</p></div>
    </x-slot>

    <div class="viveiro-report-grid">
        <section class="viveiro-list-card">
            <div class="viveiro-section-heading"><div><h2>Temperatura</h2><p>Últimas leituras registradas nos últimos 7 dias.</p></div></div>
            <div class="viveiro-table-wrap"><table class="viveiro-table"><thead><tr><th>Tanque</th><th>Temperatura</th><th>Data e horário</th></tr></thead><tbody>
                @forelse ($leituras as $leitura)
                    <tr><td>{{ $leitura->tanque ?: 'Tanque' }}</td><td>{{ number_format($leitura->temperatura, 1, ',', '.') }}°C</td><td>{{ \Carbon\Carbon::parse($leitura->created_at)->format('d/m/Y H:i') }}</td></tr>
                @empty
                    <tr><td colspan="3" class="viveiro-table-empty">Ainda não há leituras de temperatura nesse período.</td></tr>
                @endforelse
            </tbody></table></div>
        </section>

        <section class="viveiro-list-card">
            <div class="viveiro-section-heading"><div><h2>Arraçoamento</h2><p>Alimentações mais recentes.</p></div></div>
            @forelse ($alimentacoes as $alimentacao)
                <article class="viveiro-event"><span class="viveiro-event-mark">⌁</span><div><strong>{{ $alimentacao->quantidade_kg }} kg · {{ $alimentacao->tipo_racao }}</strong><p>{{ $alimentacao->tanque->nome ?: 'Tanque '.$alimentacao->id_tanque }} · {{ $alimentacao->registrado_em->format('d/m/Y H:i') }}</p></div></article>
            @empty
                <p class="viveiro-table-empty">Nenhum arraçoamento registrado.</p>
            @endforelse
        </section>

        <section class="viveiro-list-card">
            <div class="viveiro-section-heading"><div><h2>Mortalidade</h2><p>Ocorrências mais recentes.</p></div></div>
            @forelse ($mortalidades as $mortalidade)
                <article class="viveiro-event"><span class="viveiro-event-mark is-critical">!</span><div><strong>{{ $mortalidade->quantidade }} peixes</strong><p>{{ $mortalidade->tanque->nome ?: 'Tanque '.$mortalidade->id_tanque }} · {{ $mortalidade->ocorrido_em->format('d/m/Y') }}</p></div></article>
            @empty
                <p class="viveiro-table-empty">Nenhuma mortalidade registrada.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
