<?php

use App\Http\Controllers\Api\{
    CotacaoController
    };

use Illuminate\Support\Facades\Route;

Route::put('cotacao', [CotacaoController::class, 'calculo'])->name('calculo');
Route::apiResource('cotacao', CotacaoController::class);

Route::get('transportadora', [CotacaoController::class, 'transportadora'])->name('transportadora');
Route::get('calcular', [CotacaoController::class, 'calcular'])->name('calcular');

//Route::post('cotacao', [CotacaoController::class, 'store'])->name('store');

Route::view('/', 'index');
