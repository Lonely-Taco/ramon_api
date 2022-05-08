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
})->name('home');

Route::get('/all-chart', function () {
    $tags = \App\Models\Tag::all()->sortBy('name');
    return view('charts.all-chart', ['tags' => $tags]);
})->name('all-chart');

Route::group([
    'prefix' => 'games',
    'as'     => 'games.',
], function () {
    Route::get('/', [ConsumeGamesController::class, 'index'])->name('gameIndex');
    Route::get('/{id}', [ConsumeGamesController::class, 'show'])->name('gameShow');
    Route::get('/delete/{id}', [ConsumeGamesController::class, 'destroy']);
    Route::get('chart/game-chart', [ConsumeGamesController::class, 'chart'])->name('game-chart');
});

Route::group([
    'prefix' => 'movies',
    'as'     => 'movies.',
], function () {
    Route::get('/', [ConsumeMoviesController::class, 'index']);
    Route::get('/{id}', [ConsumeMoviesController::class, 'show']);
    Route::get('/delete/{id}', [ConsumeMoviesController::class, 'destroy']);
    Route::get('chart/movie-chart', [ConsumeMoviesController::class, 'chart'])->name('movie-chart');
});

Route::group([
    'prefix' => 'books',
    'as'     => 'books.',
], function () {
    Route::get('/', [ConsumeBooksController::class, 'index']);
    Route::get('/{id}', [ConsumeBooksController::class, 'show']);
    Route::get('/delete/{id}', [ConsumeBooksController::class, 'destroy']);
    Route::get('chart/book-chart', [ConsumeBooksController::class, 'chart'])->name('book-chart');
});



