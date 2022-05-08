<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TagController;
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
 *     path="/api/game/{id}",
 *     description="get a game",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/game/{id}', [GameController::class, 'show']);

/**
 * @OA\Put    (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="read")
 * )
 */
Route::put('/game/{id}', [GameController::class, 'edit']);

/**
 * @OA\Post   (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::post('/game', [GameController::class, 'create']);

/**
 * @OA\Delete (
 *     path="/api/game/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/game/{id}', [GameController::class, 'destroy']);

Route::post('/game/giveTag/{id}', [GameController::class, 'tag']);

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
 *     path="/api/book/{id}",
 *     description="det books",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/book/{id}', [BookController::class, 'show']);

/**
 * @OA\Post   (
 *     path="/api/book",
 *     description="create a book",
 *     @OA\Response(response="default", description="post")
 * )
 */
Route::post('/book', [BookController::class, 'create']);

/**
 * @OA\Put   (
 *     path="/api/book/{id}",
 *     description="update book",
 *     @OA\Response(response="default", description="read")
 * )
 */
Route::put('/book/{id}', [BookController::class, 'edit']);

/**
 * @OA\Delete (
 *     path="/api/book/{id}",
 *     description="games",
 *     @OA\Response(response="default", description="delete")
 * )
 */
Route::delete('/book/{id}', [BookController::class, 'destroy']);

Route::post('/book/giveTag/{id}', [BookController::class, 'tag']);

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
 *     path="/api/movie/{id}",
 *     description="get a movie",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/movie/{id}', [MovieController::class, 'show']);

/**
 * @OA\Post     (
 *     path="/api/movie",
 *     description="create movie",
 *     @OA\Response(response="default", description="create")
 * )
 */
Route::post('/movie', [MovieController::class, 'create']);

/**
 * @OA\Put    (
 *     path="/api/movie/{id}",
 *     description="movie",
 *     @OA\Response(response="default", description="patch")
 * )
 */
Route::put('/movie/{id}', [MovieController::class, 'edit']);

/**
 * @OA\Delete (
 *     path="/api/movie/{id}",
 *     description="delete movie",
 *     @OA\Response(response="default", description="delete")
 * )
 */

Route::delete('/movie/{id}', [MovieController::class, 'destroy']);

Route::post('/movie/giveTag/{id}', [MovieController::class, 'tag']);

//-----------------------------------------------------------------------------
// Tag endpoints
//-----------------------------------------------------------------------------

/**
 * @OA\Get(
 *     path="/api/tags",
 *     description="tags",
 *     @OA\Response(response="default", description="get all tags")
 * )
 */
Route::get('/tags', [TagController::class, 'index']);

/**
 * @OA\Get   (
 *     path="/api/tag/{id}",
 *     description="get a tag",
 *     @OA\Response(response="default", description="get")
 * )
 */
Route::get('/tag/{id}', [TagController::class, 'show']);

/**
 * @OA\Post     (
 *     path="/api/tag",
 *     description="create tag",
 *     @OA\Response(response="default", description="create")
 * )
 */
Route::post('/tag', [TagController::class, 'create']);

/**
 * @OA\Put   (
 *     path="/api/tag/{id}",
 *     description="tag",
 *     @OA\Response(response="default", description="patch")
 * )
 */
Route::put('/tag/{id}', [TagController::class, 'edit']);

/**
 * @OA\Delete (
 *     path="/api/tag/{id}",
 *     description="delete tag",
 *     @OA\Response(response="default", description="delete")
 * )
 */

Route::delete('/tag/{id}', [TagController::class, 'destroy']);
