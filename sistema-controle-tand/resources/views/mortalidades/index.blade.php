<x-app-layout>
    <x-slot name="header">
        <div><p class="viveiro-eyebrow">ACOMPANHAMENTO</p><h1 class="viveiro-heading">Registro de mortalidade</h1><p class="viveiro-subheading">Registre perdas e observações para acompanhar a saúde dos peixes.</p></div>
    </x-slot>

    @if (session('status'))<p class="viveiro-success" role="status">{{ session('status') }}</p>@endif
    @if ($errors->any())<div class="viveiro-error" role="alert"><strong>Não foi possível salvar. Verifique os campos:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="viveiro-two-column">
        <form class="viveiro-form-card" method="POST" action="{{ route('mortalidades.store') }}">
            @csrf
            <div class="viveiro-form-section">
                <h2>Dados da ocorrência</h2>
                @if ($tanques->isEmpty())
                    <p>Cadastre um tanque antes de registrar mortalidade.</p>
                    <a class="viveiro-button viveiro-button-primary" href="{{ route('tanques.create') }}">Cadastrar tanque</a>
                @else
                    <label class="viveiro-form-field"><span>Tanque</span><select name="id_tanque" required>@foreach ($tanques as $tanque)<option value="{{ $tanque->id_tanque }}" @selected(old('id_tanque', request('tanque')) == $tanque->id_tanque)>{{ $tanque->nome ?: 'Tanque '.$tanque->id_tanque }}</option>@endforeach</select></label>
                    <label class="viveiro-form-field"><span>Quantidade de peixes perdidos</span><input type="number" name="quantidade" value="{{ old('quantidade') }}" min="1" max="1000000" step="1" required></label>
                    <label class="viveiro-form-field"><span>Data da ocorrência</span><input type="date" name="ocorrido_em" value="{{ old('ocorrido_em', now()->toDateString()) }}" required></label>
                    <label class="viveiro-form-field"><span>Observação</span><textarea name="observacao" rows="4" maxlength="2000" placeholder="Descreva o que observou...">{{ old('observacao') }}</textarea></label>
                    <div class="viveiro-form-actions"><button class="viveiro-button viveiro-button-primary" type="submit">Salvar registro</button></div>
                @endif
            </div>
        </form>

        <section class="viveiro-list-card">
            <div class="viveiro-section-heading"><div><h2>Eventos recentes</h2><p>Registros de mortalidade dos seus tanques.</p></div></div>
            @forelse ($mortalidades as $mortalidade)
                <article class="viveiro-event">
                    <span class="viveiro-event-mark is-critical">!</span>
                    <div><strong>{{ $mortalidade->quantidade }} peixes perdidos</strong><p>{{ $mortalidade->tanque->nome ?: 'Tanque '.$mortalidade->id_tanque }} · {{ $mortalidade->ocorrido_em->format('d/m/Y') }}</p>
                        @if ($mortalidade->observacao)<p>{{ $mortalidade->observacao }}</p>@endif
                    </div>
                </article>
            @empty
                <p class="viveiro-table-empty">Nenhuma ocorrência registrada ainda.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
