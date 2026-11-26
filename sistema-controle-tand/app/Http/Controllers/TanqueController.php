<?php

namespace App\Http\Controllers;

use App\Models\Tanque;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TanqueController extends Controller
{
    public function index(Request $request): View
    {
        $consulta = $this->tanquesDoUsuario()->with('sensores')->orderBy('id_tanque');
        $busca = trim((string) $request->query('busca', ''));

        if ($busca !== '') {
            $consulta->where('nome', 'like', '%'.$busca.'%');
        }

        $tanques = $consulta->get();

        return view('tanques.index', compact('tanques'));
    }

    public function create(): View
    {
        return view('tanques.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:80'],
            'dimensoes' => ['nullable', 'string', 'max:100'],
            'quantidade_alevinos' => ['nullable', 'integer', 'min:0'],
            'especie' => ['nullable', 'string', 'max:60'],
            'volume_estimado' => ['nullable', 'numeric', 'gt:0'],
            'data_povoamento' => ['required', 'date'],
            'temperatura_min' => ['required', 'numeric', 'between:-5,50'],
            'temperatura_max' => ['required', 'numeric', 'between:-5,50', 'gt:temperatura_min'],
            'temperatura_alerta_min' => ['required', 'numeric', 'between:-5,50'],
            'temperatura_alerta_max' => ['required', 'numeric', 'between:-5,50', 'gt:temperatura_alerta_min'],
            'temperatura_critica_min' => ['required', 'numeric', 'between:-5,50'],
            'temperatura_critica_max' => ['required', 'numeric', 'between:-5,50', 'gt:temperatura_critica_min'],
            'ph_real' => ['nullable', 'numeric', 'between:0,14'],
        ]);

        DB::transaction(function () use ($dados): void {
            $tanque = Tanque::create([
                'id_usuario' => auth()->id(),
                'nome' => $dados['nome'],
                'dimensoes' => $dados['dimensoes'] ?? null,
                'quantidade_alevinos' => $dados['quantidade_alevinos'] ?? null,
                'especie' => $dados['especie'] ?? null,
                'volume_estimado' => $dados['volume_estimado'] ?? null,
                'datatanque_registrada' => $dados['data_povoamento'],
                'tipo' => 'escavado',
                'status' => 'normal',
            ]);

            $tanque->sensores()->create([
                'temperatura_real' => null,
                'temperatura_min_tanque' => $dados['temperatura_min'],
                'temperatura_max_tanque' => $dados['temperatura_max'],
                'temperatura_alerta_min' => $dados['temperatura_alerta_min'],
                'temperatura_alerta_max' => $dados['temperatura_alerta_max'],
                'temperatura_critica_min' => $dados['temperatura_critica_min'],
                'temperatura_critica_max' => $dados['temperatura_critica_max'],
                'ph_min' => 6.5,
                'ph_max' => 8.5,
                'ph_real' => $dados['ph_real'] ?? 7.0,
                'manutencao' => false,
                'datasensores_registrada' => $dados['data_povoamento'],
            ]);
        });

        return redirect()->route('tanques.index')->with('status', 'Tanque cadastrado com sucesso.');
    }

    public function show(int $id): View
    {
        $tanque = $this->tanquesDoUsuario()
            ->with(['sensores', 'alimentacoes', 'mortalidades'])
            ->findOrFail($id);
        $sensor = $tanque->sensores->first();
        $inicioDoDia = now()->startOfDay();
        $leiturasHoje = $sensor
            ? DB::table('leituras_temperatura')
                ->where('id_sensores', $sensor->id_sensores)
                ->where('created_at', '>=', $inicioDoDia)
                ->pluck('temperatura')
            : collect();

        $estatisticas = [
            'min' => $leiturasHoje->min(),
            'media' => $leiturasHoje->avg(),
            'max' => $leiturasHoje->max(),
        ];

        $eventos = $tanque->alimentacoes
            ->map(fn ($item) => [
                'descricao' => 'Arraçoamento registrado — '.number_format($item->quantidade_kg, 1, ',', '.').' kg',
                'data' => $item->registrado_em,
            ])
            ->concat($tanque->mortalidades->map(fn ($item) => [
                'descricao' => 'Mortalidade registrada — '.$item->quantidade.' peixes',
                'data' => $item->ocorrido_em->startOfDay(),
            ]))
            ->sortByDesc('data')
            ->take(8)
            ->values();

        return view('tanques.show', compact('tanque', 'sensor', 'estatisticas', 'eventos'));
    }

    private function tanquesDoUsuario()
    {
        return Tanque::where('id_usuario', auth()->id());
    }
}
