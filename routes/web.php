<?php

use App\Http\Controllers\ConsumeBooksController;
use App\Http\Controllers\ConsumeGamesController;
use App\Http\Controllers\ConsumeMoviesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'games',
    'as'     => 'games.',
], function () {
    Route::get('/', [ConsumeGamesController::class, 'index']);
    Route::get('/{id}', [ConsumeGamesController::class, 'show']);
    Route::get('/delete/{id}', [ConsumeGamesController::class, 'destroy']);
});

Route::group([
    'prefix' => 'movies',
    'as'     => 'movies.',
], function () {
    Route::get('/', [ConsumeMoviesController::class, 'index']);
    Route::get('/{id}', [ConsumeMoviesController::class, 'show']);
    Route::get('/delete/{id}', [ConsumeMoviesController::class, 'destroy']);
});

Route::group([
    'prefix' => 'books',
    'as'     => 'books.',
], function () {
    Route::get('/', [ConsumeBooksController::class, 'index']);
    Route::get('/{id}', [ConsumeBooksController::class, 'show']);
    Route::get('/delete/{id}', [ConsumeBooksController::class, 'destroy']);
});

