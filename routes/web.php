<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('/login', [UserController::class, 'loginWeb']);
Route::post('/logout', [UserController::class, 'logoutWeb']);

