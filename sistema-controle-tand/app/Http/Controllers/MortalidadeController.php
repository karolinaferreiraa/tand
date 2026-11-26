<?php

namespace App\Http\Controllers;

use App\Models\Mortalidade;
use App\Models\Tanque;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MortalidadeController extends Controller
{
    public function index(): View
    {
        $tanques = Tanque::where('id_usuario', auth()->id())->orderBy('nome')->get();
        $mortalidades = Mortalidade::whereHas('tanque', fn ($query) => $query->where('id_usuario', auth()->id()))
            ->with('tanque')
            ->orderByDesc('ocorrido_em')
            ->limit(20)
            ->get();

        return view('mortalidades.index', compact('tanques', 'mortalidades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'id_tanque' => ['required', 'integer'],
            'quantidade' => ['required', 'integer', 'min:1', 'max:1000000'],
            'observacao' => ['nullable', 'string', 'max:2000'],
            'ocorrido_em' => ['required', 'date'],
        ]);

        $tanque = Tanque::where('id_usuario', auth()->id())->findOrFail($dados['id_tanque']);
        $tanque->mortalidades()->create($dados);

        return redirect()->route('mortalidades.index')->with('status', 'Mortalidade registrada com sucesso.');
    }
}
