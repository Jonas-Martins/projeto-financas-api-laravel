<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransitionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ping', function (){
    $array = ['messagte' => 'pong'];
    return $array;
});

Route::prefix('user')->group(function (){
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);

    Route::middleware('auth:sanctum')->put('/update', [UserController::class, 'update']);

    Route::middleware('auth:sanctum')->delete('/delete', [UserController::class, 'delete']);

    Route::middleware('auth:sanctum')->get('/auth', function (Request $request) {
        return $request->user();
    });
});

Route::prefix('category')->group(function (){
    Route::middleware('auth:sanctum')->post('create', [CategoryController::class, 'create']);

    Route::middleware('auth:sanctum')->get('all', [CategoryController::class, 'readAll']);

    Route::middleware('auth:sanctum')->put('update/{id}', [CategoryController::class, 'update']);

    Route::middleware('auth:sanctum')->delete('delete/{id}', [CategoryController::class, 'delete']);
});

Route::prefix('transition')->group(function (){
    Route::middleware('auth:sanctum')->post('/create', [TransitionController::class, 'create']);

    Route::middleware('auth:sanctum')->get('/all-category/{id}', [TransitionController::class, 'readAllCategory']);
    Route::middleware('auth:sanctum')->get('/all', [TransitionController::class, 'readAll']);

    Route::middleware('auth:sanctum')->put('/update', [TransitionController::class, 'update']);

    Route::middleware('auth:sanctum')->delete('delete/{id}', [TransitionController::class, 'delete']);
});
