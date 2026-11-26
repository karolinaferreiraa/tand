<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($sensor)
                        <h3 class="text-lg font-semibold mb-4">
                            Temperatura atual
                        </h3>

                        @if ($sensor->temperatura_real !== null)
                            <p id="temperatura-atual" class="text-4xl font-bold">
                                {{ number_format($sensor->temperatura_real, 2, ',', '.') }} °C
                            </p>
                        @else
                            <p>Nenhuma temperatura registrada ainda.</p>
                        @endif

                        <p class="text-sm text-gray-500 mt-2">
                            Sensor #{{ $sensor->id_sensores }}
                        </p>

                        @if ($leituras->isNotEmpty())
                            <p id="ultima-leitura" class="text-sm text-gray-500 mt-2">
                                Última leitura:
                                {{ \Carbon\Carbon::parse($leituras->first()->created_at)->format('d/m/Y H:i:s') }}
                            </p>
                        @endif

                        <h3 class="text-lg font-semibold mt-8 mb-4">
                            Histórico de temperaturas
                        </h3>

                        @if ($leituras->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="py-2">Temperatura</th>
                                            <th class="py-2">Data e horário</th>
                                        </tr>
                                    </thead>

                                    <tbody id="historico-leituras">
                                        @foreach ($leituras as $leitura)
                                            <tr class="border-b">
                                                <td class="py-2">
                                                    {{ number_format($leitura->temperatura, 2, ',', '.') }} °C
                                                </td>
                                                <td class="py-2">
                                                    {{ \Carbon\Carbon::parse($leitura->created_at)->format('d/m/Y H:i:s') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Nenhuma leitura registrada ainda.</p>
                        @endif
                    @else
                        <p>Nenhum sensor encontrado para sua conta.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <script>
        async function atualizarTemperatura() {
            try {
                const resposta = await fetch("{{ route('dashboard.dados') }}");

                if (!resposta.ok) {
                    throw new Error('Erro ao consultar as temperaturas.');
                }

                const dados = await resposta.json();

                if (!dados.sensor) {
                    return;
                }

                const elemento = document.getElementById('temperatura-atual');

                if (elemento) {
                    const temperatura = Number(dados.sensor.temperatura);

                    elemento.textContent = temperatura.toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + ' °C';
                }
                const ultimaLeitura = dados.leituras[0];
                const elementoHorario = document.getElementById('ultima-leitura');

                if (ultimaLeitura && elementoHorario) {
                    const [data, hora] = ultimaLeitura.created_at.split(' ');
                    const [ano, mes, dia] = data.split('-');

                    elementoHorario.textContent =
                        `Última leitura: ${dia}/${mes}/${ano} ${hora}`;
                }

                const corpoHistorico = document.getElementById('historico-leituras');

                if (corpoHistorico) {
                    corpoHistorico.replaceChildren();

                    dados.leituras.forEach(leitura => {
                        const linha = document.createElement('tr');
                        linha.className = 'border-b';

                        const colunaTemperatura = document.createElement('td');
                        colunaTemperatura.className = 'py-2';

                        const temperatura = Number(leitura.temperatura);

                        colunaTemperatura.textContent = temperatura.toLocaleString('pt-BR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + ' °C';

                        const colunaHorario = document.createElement('td');
                        colunaHorario.className = 'py-2';

                        const [data, hora] = leitura.created_at.replace('T', ' ').split(' ');
                        const [ano, mes, dia] = data.split('-');

                        colunaHorario.textContent =
                            `${dia}/${mes}/${ano} ${hora.slice(0, 8)}`;

                        linha.appendChild(colunaTemperatura);
                        linha.appendChild(colunaHorario);

                        corpoHistorico.appendChild(linha);
                    });
                }

            } catch (erro) {
                console.error('Erro ao atualizar o dashboard:', erro);
            }
        }

        setInterval(atualizarTemperatura, 5000);
    </script>
</x-app-layout>
