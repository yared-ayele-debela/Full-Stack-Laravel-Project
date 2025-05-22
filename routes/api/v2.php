<?php

use App\Http\Controllers\Api\V2\TaskController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')->prefix('v2')->group(function () {
    Route::apiResource('/tasks', TaskController::class)->names([
        'index'   => 'v2.tasks.index',
        'store'   => 'v2.tasks.store',
        'show'    => 'v2.tasks.show',
        'update'  => 'v2.tasks.update',
        'destroy' => 'v2.tasks.destroy',
    ]);

    Route::post('/tasks/{id}/completed', [TaskController::class, 'mark_as_completed'])->name('v2.tasks.completed');
});
