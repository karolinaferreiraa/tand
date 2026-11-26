<?php

namespace App\Http\Controllers;

use App\Models\Tanque;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $tanques = Tanque::where('id_usuario', auth()->id())
            ->with('sensores')
            ->orderBy('id_tanque')
            ->get();

        $contagens = [
            'normal' => 0,
            'atencao' => 0,
            'critico' => 0,
        ];

        foreach ($tanques as $tanque) {
            $sensor = $tanque->sensores->first();

            if ($sensor && isset($contagens[$sensor->statusTemperatura()])) {
                $contagens[$sensor->statusTemperatura()]++;
            }
        }

        return view('dashboard', compact('tanques', 'contagens'));
    }

    public function dados(): JsonResponse
    {
        $tanques = Tanque::where('id_usuario', auth()->id())
            ->with('sensores')
            ->orderBy('id_tanque')
            ->get()
            ->map(function (Tanque $tanque): array {
                $sensor = $tanque->sensores->first();

                return [
                    'id' => $tanque->id_tanque,
                    'temperatura' => $sensor?->temperatura_real,
                    'status' => $sensor?->statusTemperatura() ?? 'sem-leitura',
                    'atualizado_em' => $sensor?->updated_at?->diffForHumans() ?? 'sem leitura',
                ];
            });

        return response()->json(['tanques' => $tanques]);
    }
}
