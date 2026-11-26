<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="viveiro-eyebrow">CONFIGURAÇÃO</p>
            <h1 class="viveiro-heading">Novo tanque</h1>
            <p class="viveiro-subheading">Informe os dados do viveiro e configure a faixa de temperatura.</p>
        </div>
    </x-slot>

    @if ($errors->any())
        <div class="viveiro-error" role="alert">
            <strong>Revise os campos destacados:</strong>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form class="viveiro-form-card" method="POST" action="{{ route('tanques.store') }}">
        @csrf
        <div class="viveiro-form-section">
            <h2>Informações do tanque</h2>
            <div class="viveiro-form-grid">
                <label class="viveiro-form-field">
                    <span>Identificação (nome e número)</span>
                    <input name="nome" value="{{ old('nome') }}" placeholder="Ex.: Tanque 03" required maxlength="80">
                    @error('nome')<small>{{ $message }}</small>@enderror
                </label>
                <label class="viveiro-form-field">
                    <span>Espécie cultivada</span>
                    <input name="especie" value="{{ old('especie', 'Tilápia') }}" maxlength="60">
                    @error('especie')<small>{{ $message }}</small>@enderror
                </label>
                <label class="viveiro-form-field">
                    <span>Dimensões aproximadas</span>
                    <input name="dimensoes" value="{{ old('dimensoes') }}" placeholder="Ex.: 30 m x 15 m x 1,5 m" maxlength="100">
                    @error('dimensoes')<small>{{ $message }}</small>@enderror
                </label>
                <label class="viveiro-form-field">
                    <span>Volume estimado (m³)</span>
                    <input type="number" name="volume_estimado" value="{{ old('volume_estimado') }}" min="0.01" step="0.01">
                    @error('volume_estimado')<small>{{ $message }}</small>@enderror
                </label>
                <label class="viveiro-form-field">
                    <span>Quantidade inicial de alevinos</span>
                    <input type="number" name="quantidade_alevinos" value="{{ old('quantidade_alevinos') }}" min="0" step="1">
                    @error('quantidade_alevinos')<small>{{ $message }}</small>@enderror
                </label>
                <label class="viveiro-form-field">
                    <span>Data de povoamento</span>
                    <input type="date" name="data_povoamento" value="{{ old('data_povoamento', now()->toDateString()) }}" required>
                    @error('data_povoamento')<small>{{ $message }}</small>@enderror
                </label>
            </div>
        </div>

        <div class="viveiro-form-section">
            <h2>Faixa de temperatura</h2>
            <p class="viveiro-form-hint">Defina os valores ideais, de alerta e de risco crítico para este tanque.</p>
            <div class="viveiro-form-grid viveiro-form-grid-3">
                <label class="viveiro-form-field"><span>Temperatura ideal mínima (°C)</span><input type="number" name="temperatura_min" value="{{ old('temperatura_min', 24) }}" step="0.1" required>@error('temperatura_min')<small>{{ $message }}</small>@enderror</label>
                <label class="viveiro-form-field"><span>Temperatura ideal máxima (°C)</span><input type="number" name="temperatura_max" value="{{ old('temperatura_max', 30) }}" step="0.1" required>@error('temperatura_max')<small>{{ $message }}</small>@enderror</label>
                <label class="viveiro-form-field"><span>pH atual (opcional)</span><input type="number" name="ph_real" value="{{ old('ph_real') }}" min="0" max="14" step="0.1">@error('ph_real')<small>{{ $message }}</small>@enderror</label>
                <label class="viveiro-form-field"><span>Limite de alerta mínimo (°C)</span><input type="number" name="temperatura_alerta_min" value="{{ old('temperatura_alerta_min', 24) }}" step="0.1" required>@error('temperatura_alerta_min')<small>{{ $message }}</small>@enderror</label>
                <label class="viveiro-form-field"><span>Limite de alerta máximo (°C)</span><input type="number" name="temperatura_alerta_max" value="{{ old('temperatura_alerta_max', 32) }}" step="0.1" required>@error('temperatura_alerta_max')<small>{{ $message }}</small>@enderror</label>
                <label class="viveiro-form-field"><span>Limite crítico mínimo (°C)</span><input type="number" name="temperatura_critica_min" value="{{ old('temperatura_critica_min', 22) }}" step="0.1" required>@error('temperatura_critica_min')<small>{{ $message }}</small>@enderror</label>
                <label class="viveiro-form-field"><span>Limite crítico máximo (°C)</span><input type="number" name="temperatura_critica_max" value="{{ old('temperatura_critica_max', 34) }}" step="0.1" required>@error('temperatura_critica_max')<small>{{ $message }}</small>@enderror</label>
            </div>
        </div>

        <div class="viveiro-form-actions">
            <a class="viveiro-button viveiro-button-muted" href="{{ route('tanques.index') }}">Cancelar</a>
            <button class="viveiro-button viveiro-button-primary" type="submit">Salvar tanque</button>
        </div>
    </form>
</x-app-layout>
