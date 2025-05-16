<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UnifiedController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/list', [UnifiedController::class, 'list']);
    Route::post('/create', [UnifiedController::class, 'create']);
    Route::put('/update', [UnifiedController::class, 'update']);
});