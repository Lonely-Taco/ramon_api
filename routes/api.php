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

/**
 * @OA\Get(
 *     path="/api/games",
 *     description="games",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
Route::get('/games', [GameController::class, 'index']);

/**
 * @OA\Get   (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/game/{id}', [GameController::class, 'show']);

/**
 * @OA\Patch  (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="read")
 * )
 */
Route::post('/game', [GameController::class, 'create']);

/**
 * @OA\Post   (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::patch('/game/id={id}', [GameController::class, 'edit']);

/**
 * @OA\Delete (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/game/{id}', [GameController::class, 'destroy']);

/**
 * @OA\Get(
 *     path="/api/games",
 *     description="games",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
Route::get('/books', [BookController::class, 'index']);

/**
 * @OA\Get   (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/book/{id}', [BookController::class, 'show']);

/**
 * @OA\Patch  (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="read")
 * )
 */
Route::post('/book', [BookController::class, 'create']);

/**
 * @OA\Post   (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::patch('/book/id={id}', [BookController::class, 'edit']);
/**
 * @OA\Delete (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/book/{id}', [BookController::class, 'destroy']);

/**
 * @OA\Get(
 *     path="/api/games",
 *     description="games",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
Route::get('/movies', [MovieController::class, 'index']);
/**
 * @OA\Get   (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/movie/{id}', [MovieController::class, 'show']);
/**
 * @OA\Patch  (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="read")
 * )
 */
Route::post('/movie', [MovieController::class, 'create']);
/**
 * @OA\Post   (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::patch('/movie/id={id}', [MovieController::class, 'edit']);
/**
 * @OA\Delete (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/movie/{id}', [MovieController::class, 'destroy']);
