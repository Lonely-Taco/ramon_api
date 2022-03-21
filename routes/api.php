<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MovieController;
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
Route::post('/game', [GameController::class, 'create']);
Route::patch('/game/{id}', [GameController::class, 'edit']);
Route::delete('/game/{id}', [GameController::class, 'destroy']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/book/{id}', [BookController::class, 'show']);
Route::post('/book', [BookController::class, 'create']);
Route::patch('/book/{id}', [BookController::class, 'edit']);
Route::delete('/book/{id}', [BookController::class, 'destroy']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movie/{id}', [MovieController::class, 'show']);
Route::post('/movie/', [MovieController::class, 'create']);
Route::patch('/movie/{id}', [MovieController::class, 'edit']);
Route::delete('/movie/{id}', [MovieController::class, 'destroy']);
