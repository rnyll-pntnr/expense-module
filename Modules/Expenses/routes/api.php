<?php

use Illuminate\Support\Facades\Route;
use Modules\Expenses\Controllers\ExpenseController;
use Modules\Expenses\Controllers\SwaggerController;

Route::prefix('/v1/api/expenses')->group(function () {
    Route::get('/', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/{id}', [ExpenseController::class, 'show'])->name('expenses.show');
    Route::post('/', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
});
