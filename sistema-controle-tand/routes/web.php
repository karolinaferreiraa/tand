<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\AlimentacaoController;
use App\Http\Controllers\MortalidadeController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\TanqueController;
use Illuminate\Support\Facades\Route;
use App\Models\Sensor;
use Illuminate\Support\Facades\DB;

Route::view('/', 'welcome')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/dashboard/dados', [DashboardController::class, 'dados'])->name('dashboard.dados');
    Route::get('/tanques', [TanqueController::class, 'index'])->name('tanques.index');
    Route::get('/tanques/novo', [TanqueController::class, 'create'])->name('tanques.create');
    Route::post('/tanques', [TanqueController::class, 'store'])->name('tanques.store');
    Route::get('/tanques/{id}', [TanqueController::class, 'show'])->whereNumber('id')->name('tanques.show');
    Route::get('/alimentacoes', [AlimentacaoController::class, 'index'])->name('alimentacoes.index');
    Route::post('/alimentacoes', [AlimentacaoController::class, 'store'])->name('alimentacoes.store');
    Route::get('/mortalidade', [MortalidadeController::class, 'index'])->name('mortalidades.index');
    Route::post('/mortalidade', [MortalidadeController::class, 'store'])->name('mortalidades.store');
    Route::get('/alertas', AlertaController::class)->name('alertas.index');
    Route::get('/relatorios', RelatorioController::class)->name('relatorios.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
