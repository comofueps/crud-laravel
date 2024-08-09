<?php

use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/students', [StudentController::class, 'index']);

Route::get('/student/{id}', [StudentController::class, 'show']);

Route::post('/students', [StudentController::class, 'store']);

Route::put('/student/{id}', [StudentController::class, 'update']);

Route::patch('/student/{id}', [StudentController::class, 'updatePartial']);

Route::delete('/student/{id}', [StudentController::class, 'destroy']);
