<?php

use App\Http\Controllers\AppointmentController;
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

    // Rota para buscar serviços com filtros
    Route::get('/filter', [ServiceController::class, 'filter']);
});

// Grupo de rotas para o recurso Appointment
Route::prefix('appointments')->group(function () {
    // Rota para listar todos os agendamentos
    Route::get('/', [AppointmentController::class, 'index']);

    // Rota para criar um novo agendamento
    Route::post('/', [AppointmentController::class, 'store']);

    // Rota para mostrar um agendamento específico
    Route::get('/{id}', [AppointmentController::class, 'show']);

    // Rota para atualizar um agendamento específico
    Route::put('/{id}', [AppointmentController::class, 'update']);

    // Rota para deletar um agendamento específico
    Route::delete('/{id}', [AppointmentController::class, 'destroy']);
});
