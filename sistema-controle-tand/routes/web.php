<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Sensor;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $sensor = Sensor::whereHas('tanque', function ($query) {
        $query->where('id_usuario', auth()->id());
    })->orderBy('id_sensores')->first();

    $leituras = $sensor
        ? DB::table('leituras_temperatura')
            ->where('id_sensores', $sensor->id_sensores)
            ->orderByDesc('id')
            ->limit(10)
            ->get()
        : collect();

    return view('dashboard', compact('sensor', 'leituras'));

})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard/dados', function () {

    $sensor = Sensor::whereHas('tanque', function ($query) {
        $query->where('id_usuario', auth()->id());
    })->orderBy('id_sensores')->first();

    if (!$sensor) {
        return response()->json([
            'sensor' => null,
            'leituras' => [],
        ]);
    }

    $leituras = DB::table('leituras_temperatura')
        ->where('id_sensores', $sensor->id_sensores)
        ->orderByDesc('id')
        ->limit(10)
        ->get();

    return response()->json([
        'sensor' => [
            'id' => $sensor->id_sensores,
            'temperatura' => $sensor->temperatura_real,
        ],
        'leituras' => $leituras,
    ]);

})->middleware(['auth', 'verified'])->name('dashboard.dados');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';
