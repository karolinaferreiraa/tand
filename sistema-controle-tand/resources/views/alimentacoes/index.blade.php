<x-app-layout>
    <x-slot name="header">
        <div><p class="viveiro-eyebrow">ROTINA</p><h1 class="viveiro-heading">Registrar arraçoamento</h1><p class="viveiro-subheading">Registre a alimentação para manter o histórico de cada tanque.</p></div>
    </x-slot>

    @if (session('status'))<p class="viveiro-success" role="status">{{ session('status') }}</p>@endif
    @if ($errors->any())<div class="viveiro-error" role="alert"><strong>Não foi possível salvar. Verifique os campos:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="viveiro-two-column">
        <form class="viveiro-form-card" method="POST" action="{{ route('alimentacoes.store') }}">
            @csrf
            <div class="viveiro-form-section">
                <h2>Dados da alimentação</h2>
                @if ($tanques->isEmpty())
                    <p>Cadastre um tanque antes de registrar o arraçoamento.</p>
                    <a class="viveiro-button viveiro-button-primary" href="{{ route('tanques.create') }}">Cadastrar tanque</a>
                @else
                    <label class="viveiro-form-field"><span>Tanque</span><select name="id_tanque" required>@foreach ($tanques as $tanque)<option value="{{ $tanque->id_tanque }}" @selected(old('id_tanque', request('tanque')) == $tanque->id_tanque)>{{ $tanque->nome ?: 'Tanque '.$tanque->id_tanque }}</option>@endforeach</select></label>
                    <label class="viveiro-form-field"><span>Quantidade (kg)</span><input type="number" name="quantidade_kg" value="{{ old('quantidade_kg', '2.0') }}" min="0.01" max="10000" step="0.01" required></label>
                    <label class="viveiro-form-field"><span>Tipo de ração</span><input name="tipo_racao" value="{{ old('tipo_racao', 'Extrusada 32%') }}" maxlength="80" required></label>
                    <label class="viveiro-form-field"><span>Data e horário</span><input type="datetime-local" name="registrado_em" value="{{ old('registrado_em', now()->format('Y-m-d\TH:i')) }}" required></label>
                    <div class="viveiro-form-actions"><button class="viveiro-button viveiro-button-primary" type="submit">Registrar arraçoamento</button></div>
                @endif
            </div>
        </form>

        <section class="viveiro-list-card">
            <div class="viveiro-section-heading"><div><h2>Eventos recentes</h2><p>Últimas alimentações registradas.</p></div></div>
            @forelse ($alimentacoes as $alimentacao)
                <article class="viveiro-event">
                    <span class="viveiro-event-mark">⌁</span>
                    <div><strong>{{ $alimentacao->quantidade_kg }} kg · {{ $alimentacao->tipo_racao }}</strong><p>{{ $alimentacao->tanque->nome ?: 'Tanque '.$alimentacao->id_tanque }} · {{ $alimentacao->registrado_em->format('d/m/Y H:i') }}</p></div>
                </article>
            @empty
                <p class="viveiro-table-empty">Nenhum arraçoamento registrado ainda.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
