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

//-----------------------------------------------------------------------------
// Game endpoints
//-----------------------------------------------------------------------------

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
 *     path="/api/game/id={id}",
 *     description="get a game",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/game/id={id}', [GameController::class, 'show']);

/**
 * @OA\Patch  (
 *     path="/api/game/id={id}",
 *     description="games",
 *     @OA\Response(response="default", description="read")
 * )
 */
Route::post('/game', [GameController::class, 'create']);

/**
 * @OA\Post   (
 *     path="/api/game/?{id}",
 *     description="games",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::patch('/game/id={id}', [GameController::class, 'edit']);

/**
 * @OA\Delete (
 *     path="/api/game/id={id}",
 *     description="games",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/game/id={id}', [GameController::class, 'destroy']);

//-----------------------------------------------------------------------------
// Book endpoints
//-----------------------------------------------------------------------------

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
 *     path="/api/book/id={id}",
 *     description="det books",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/book/id={id}', [BookController::class, 'show']);

/**
 * @OA\Post   (
 *     path="/api/book/",
 *     description="create a book",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::post('/book/', [BookController::class, 'create']);

/**
 * @OA\Patch  (
 *     path="/api/book/id={id}",
 *     description="update book",
 *     @OA\Response(response="default", description="read")
 * )
 */
Route::patch('/book/id={id}', [BookController::class, 'edit']);

/**
 * @OA\Delete (
 *     path="/api/book/id={id}",
 *     description="games",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/book/id={id}', [BookController::class, 'destroy']);

//-----------------------------------------------------------------------------
// Movie endpoints
//-----------------------------------------------------------------------------

/**
 * @OA\Get(
 *     path="/api/movies",
 *     description="movies",
 *     @OA\Response(response="default", description="get all movies")
 * )
 */
Route::get('/movies', [MovieController::class, 'index']);

/**
 * @OA\Get   (
 *     path="/api/movie/id={id}",
 *     description="get a movie",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/movie/id={id}', [MovieController::class, 'show']);

/**
 * @OA\Post   (
 *     path="/api/movie/",
 *     description="create movie",
 *     @OA\Response(response="default", description="create")
 * )
 */
Route::post('/movie/id={id}', [MovieController::class, 'create']);

/**
 * @OA\Patch    (
 *     path="/api/game/id={id}",
 *     description="games",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::patch('/movie/id={id}', [MovieController::class, 'edit']);

/**
 * @OA\Delete (
 *     path="/api/movie/id={id}",
 *     description="delete movie",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/movie/id={id}', [MovieController::class, 'destroy']);
