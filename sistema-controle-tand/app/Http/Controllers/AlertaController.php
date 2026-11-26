<?php

namespace App\Http\Controllers;

use App\Models\Tanque;
use Illuminate\Contracts\View\View;

class AlertaController extends Controller
{
    public function __invoke(): View
    {
        $tanques = Tanque::where('id_usuario', auth()->id())
            ->with('sensores')
            ->get()
            ->filter(fn (Tanque $tanque) => $tanque->sensores->first()?->statusTemperatura() !== 'normal')
            ->values();

        return view('alertas.index', compact('tanques'));
    }
}
