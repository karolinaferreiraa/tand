<?php

namespace App\Http\Controllers;

use App\Models\Alimentacao;
use App\Models\Tanque;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AlimentacaoController extends Controller
{
    public function index(): View
    {
        $tanques = Tanque::where('id_usuario', auth()->id())->with('sensores')->orderBy('nome')->get();
        $alimentacoes = Alimentacao::whereHas('tanque', fn ($query) => $query->where('id_usuario', auth()->id()))
            ->with('tanque')
            ->orderByDesc('registrado_em')
            ->limit(20)
            ->get();

        return view('alimentacoes.index', compact('tanques', 'alimentacoes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'id_tanque' => ['required', 'integer'],
            'quantidade_kg' => ['required', 'numeric', 'gt:0', 'max:10000'],
            'tipo_racao' => ['required', 'string', 'max:80'],
            'registrado_em' => ['required', 'date'],
        ]);

        $tanque = Tanque::where('id_usuario', auth()->id())->findOrFail($dados['id_tanque']);
        $tanque->alimentacoes()->create($dados);

        return redirect()->route('alimentacoes.index')->with('status', 'Arraçoamento registrado com sucesso.');
    }
}
