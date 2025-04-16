<?php

use App\Http\Controllers\ListController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!dd
|
*/

Route::get('/todolist', [TaskController::class, 'read']);
Route::post('/todolist', [TaskController::class, 'create']);
Route::patch('/todolist/{id}', [TaskController::class, 'update']);
Route::patch('/todolist/{id}/downdate', [TaskController::class, 'downdate']);
Route::delete('/todolist/{id}', [TaskController::class, 'delete']);

Route::get('/todolist/lists', [ListController::class, 'read']);
Route::get('/todolist/lists/{id}', [ListController::class, 'readDetail']);
Route::post('/todolist/lists', [ListController::class, 'create']);
Route::patch('/todolist/lists/{id}', [ListController::class, 'update']);
Route::delete('/todolist/lists/{id}', [ListController::class, 'delete']);