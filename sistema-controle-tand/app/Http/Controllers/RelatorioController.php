<?php

namespace App\Http\Controllers;

use App\Models\Alimentacao;
use App\Models\Mortalidade;
use App\Models\Tanque;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function __invoke(): View
    {
        $tanqueIds = Tanque::where('id_usuario', auth()->id())->pluck('id_tanque');
        $alimentacoes = Alimentacao::whereIn('id_tanque', $tanqueIds)
            ->with('tanque')
            ->orderByDesc('registrado_em')
            ->limit(20)
            ->get();
        $mortalidades = Mortalidade::whereIn('id_tanque', $tanqueIds)
            ->with('tanque')
            ->orderByDesc('ocorrido_em')
            ->limit(20)
            ->get();
        $leituras = DB::table('leituras_temperatura')
            ->join('sensores', 'sensores.id_sensores', '=', 'leituras_temperatura.id_sensores')
            ->join('tanques', 'tanques.id_tanque', '=', 'sensores.id_tanque')
            ->where('tanques.id_usuario', auth()->id())
            ->where('leituras_temperatura.created_at', '>=', now()->subDays(7))
            ->orderByDesc('leituras_temperatura.created_at')
            ->limit(30)
            ->get([
                'tanques.nome as tanque',
                'leituras_temperatura.temperatura',
                'leituras_temperatura.created_at',
            ]);

        return view('relatorios.index', compact('alimentacoes', 'mortalidades', 'leituras'));
    }
}
