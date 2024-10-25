<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\alumnoController;

Route::get('/alumnos', [alumnoController::class, 'index']);

Route::get('/alumnos/{id}', [alumnoController::class, 'show']);

Route::post('/alumnos', [alumnoController::class, 'store']);

Route::put('/alumnos/{id}', [alumnoController::class, 'update']);

Route::delete('/alumnos/{id}', [alumnoController::class, 'destroy']);