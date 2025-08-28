<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/roles', [UserController::class, 'roles']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
