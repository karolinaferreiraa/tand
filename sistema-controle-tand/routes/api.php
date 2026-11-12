<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/teste', function () {
    return response()->json([
        'mensagem' => 'API do TAND funcionando!',
        'status' => 'ok'
    ]);
});

Route::post('/leituras', function (Request $request) {
    $dados = $request->validate([
        'id_sensores' => 'required|integer|exists:sensores,id_sensores',
        'temperatura' => 'required|numeric|between:-55,125',
    ]);

    $idLeitura = DB::transaction(function () use ($dados) {
        $id = DB::table('leituras_temperatura')->insertGetId([
            'id_sensores' => $dados['id_sensores'],
            'temperatura' => $dados['temperatura'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('sensores')
            ->where('id_sensores', $dados['id_sensores'])
            ->update([
                'temperatura_real' => $dados['temperatura'],
                'updated_at' => now(),
            ]);

        return $id;
    });

    return response()->json([
        'mensagem' => 'Temperatura registrada com sucesso!',
        'id_leitura' => $idLeitura,
    ], 201);
});
