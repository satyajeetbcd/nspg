<?php

use App\Http\Controllers\Staff\PlanController;
use Illuminate\Support\Facades\Route;

//API Routes

// TODO: Implement PlanController
Route::prefix("plan/{plan}")->group(function () {
    Route::post("update", [PlanController::class, "update"])->name("plan.update");
    Route::post('/toggle-status', [PlanController::class, 'toggleStatus'])->name('toggle-status');
});
