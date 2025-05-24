<?php

use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::apiResource('/tasks',controller: TaskController::class);
    Route::post('/tasks/{id}/complete',[TaskController::class,'mark_as_completed']);
});
