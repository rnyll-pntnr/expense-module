<?php

use Illuminate\Support\Facades\Route;
use Modules\Expenses\Controllers\ExpenseController;
use Modules\Expenses\Controllers\SwaggerController;

Route::prefix('v1/api/expenses')->group(function () {
    Route::get('/', [ExpenseController::class, 'index']);
    Route::get('/{id}', [ExpenseController::class, 'show']);
    Route::post('/', [ExpenseController::class, 'store']);
    Route::put('/{id}', [ExpenseController::class, 'update']);
    Route::delete('/{id}', [ExpenseController::class, 'destroy']);
});
