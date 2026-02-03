<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Student Routes
Route::get('/students', [App\Http\Controllers\StudentController::class, 'index']);
Route::post('/students', [App\Http\Controllers\StudentController::class, 'storeStudent']);
Route::get('/students/{id}', [App\Http\Controllers\StudentController::class, 'getOneStudent']);
Route::patch('/students/{id}', [App\Http\Controllers\StudentController::class, 'updateStudent']);
Route::delete('/students/{id}', [App\Http\Controllers\StudentController::class, 'destroyStudent']);

//Register Routes
Route::get('/registers/{id}', [App\Http\Controllers\RegisterController::class, 'getAllStudentRegisters']);
