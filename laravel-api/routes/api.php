<?php

use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Grupo de rotas para o recurso Service
Route::prefix('services')->group(function () {
    // Rota para listar todos os serviços
    Route::get('/', [ServiceController::class, 'index']);

    // Rota para criar um novo serviço
    Route::post('/', [ServiceController::class, 'store']);

    // Rota para mostrar um serviço específico
    Route::get('/{id}', [ServiceController::class, 'show']);

    // Rota para atualizar um serviço específico
    Route::put('/{id}', [ServiceController::class, 'update']);

    // Rota para deletar um serviço específico
    Route::delete('/{id}', [ServiceController::class, 'destroy']);

    // Rota para buscar serviços
    Route::get('services/filter', [ServiceController::class, 'filter']);

});
