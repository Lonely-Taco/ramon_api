<?php

use App\Http\Controllers\GameController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/games', [GameController::class, 'index']);
Route::get('/game/{id}', [GameController::class, 'show']);
Route::put('/game', [GameController::class, 'create']);
Route::patch('/game/{id}', [GameController::class, 'edit']);
Route::delete('/game/{id}', [GameController::class, 'destroy']);
