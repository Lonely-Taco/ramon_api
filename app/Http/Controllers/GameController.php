<?php

namespace App\Http\Controllers;

use App\Contracts\JsonGameValidatorInterface;
use App\Contracts\XmlGameValidatorInterface;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use XmlResponse\XmlResponse;

/**
 * @OA\PathItem (
 *  path="app/Http/Controllers"
 *     )
 * @OA\Info(
 *      version="1.0.0",
 *      title="Ramon api",
 *      description="api for games, movies and books"
 * )
 */
class GameController extends Controller
{
    public function __construct(
        protected XmlGameValidatorInterface $APIXmlValidator,
        protected JsonGameValidatorInterface $jsonGameValidator,
    )
    {
    }

    /**
     * @OA\Get(
     *      path="/api/games",
     *      operationId="index",
     *      tags={"Game"},
     *      summary="Get all games",
     *      description="Returns all games",
     *      @OA\Response(
     *          response=200,
     *          description="Games"
     *       )
     *     )
     *
     * Returns list of Games
     *
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function index(Request $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsJson()) {
            return response()->json(
                [
                    'data' => Game::all(),
                ], 200);
        }

        if ($request->wantsXml()) {
            return response()->xml(
                [
                    'data' => Game::all(),
                ], 200);
        }

        return response('Bad Request', 400);
    }

    /**
     * @OA\Get(
     *      path="/api/game/id={id}",
     *      operationId="show",
     *      tags={"Game"},
     *      summary="Get game by index",
     *      description="Returns a game by the given id",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="Game id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *      @OA\Response(
     *          response=200,
     *          description="sucess"
     *       ),
     *     @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Returns a game by index
     * @param Request $request
     * @param int $id
     * @return XmlResponse|JsonResponse|Response
     */
    public function show(Request $request, int $id): XmlResponse|JsonResponse|Response
    {
        if (Game::where('id', $id)->doesntExist()) {
            return response()->json(
                ['message' => 'The data with the following id was not found',
                 'data'    => $id,
                ], 404);
        }

        $model = Game::findOrFail($id);

        if ($request->wantsXml()) {

            return response()->xml($model, 200);
        }

        if ($request->wantsJson()) {


            return response()->json($model, 200);
        }

        return response('Bad Request', 400);
    }

    /**
     * @OA\Post(
     *      path="/api/game",
     *      operationId="create",
     *      tags={"Game"},
     *      summary="Creates and returns a game object",
     *      description="Creates and returns a game",
     *
     *        @OA\Parameter(
     *          name="name",
     *          description="Name of the game",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="release_date",
     *          description="Date released",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="categories",
     *          description="categorie",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="genres",
     *          description="genres in a string format seperated by ';'",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="positive_ratings",
     *          description="positive ratings count",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="negative_ratings",
     *          description="negative ratings count",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="sucess"
     *       ),
     *     @OA\Response(
     *          response=422,
     *          description="Unproccessed data"
     *       ),
     *     @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Creates and returns a game object
     * @param UpdateGameRequest $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(
        JsonGameValidatorInterface $jsonGameValidator,
        XmlGameValidatorInterface $gameXmlValidator,
        UpdateGameRequest $request
    ): XmlResponse|JsonResponse|Response
    {

        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $validated = $gameXmlValidator->processCreate($requestXml);

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);

        }

        $data = $request->all();

        $validated = $jsonGameValidator->processCreate($data);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }

    /**
     * @OA\Patch (
     *      path="/api/game/id={id}",
     *      operationId="edit",
     *      tags={"Game"},
     *      summary="Edit game",
     *      description="Updates a game",
     *
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *        @OA\Parameter(
     *          name="name",
     *          description="Name of the game",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="release_date",
     *          description="Date released",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="categories",
     *          description="categorie",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="genres",
     *          description="genres in a string format seperated by ';'",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="positive_ratings",
     *          description="positive ratings count",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="negative_ratings",
     *          description="negative ratings count",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="sucess"
     *       ),
     *     @OA\Response(
     *          response=422,
     *          description="Unproccessed data"
     *       ),
     *     @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Updates a game
     * @param JsonGameValidatorInterface $jsonGameValidator
     * @param int $id
     * @param UpdateGameRequest $request
     * @param XmlGameValidatorInterface $gameXmlValidator
     * @return XmlResponse|JsonResponse|Response
     */
    public function edit(
        JsonGameValidatorInterface $jsonGameValidator,
        int $id, UpdateGameRequest $request,
        XmlGameValidatorInterface $gameXmlValidator
    ): XmlResponse|JsonResponse|Response
    {

        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $validated = $gameXmlValidator->processEdit($requestXml, $id);

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        $data = $request->all();

        $validated = $jsonGameValidator->processEdit($data, $id);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }

    /**
     * @OA\Delete (
     *      path="/api/game/id={id}",
     *      operationId="destroy",
     *      tags={"Game"},
     *      summary="Delete a game",
     *      description="Delete a game with the given id",
     *
     *     @OA\Parameter(
     *          name="id",
     *          description="Game id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *     @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Delete a game with the given id
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function destroy(int $id, Request $request): XmlResponse|JsonResponse|Response
    {
        if (Game::where('id', $id)->doesntExist()) {
            return response(
                [
                    'message' => 'The data with the following id was not found',
                    'data'    => $id,
                ], 404);
        }

        $model = Game::findOrFail($id);

        if ($request->wantsXml()) {

            $model->delete();

            return response()->xml(
                [
                    'message' => 'The data has been deleted.',
                    'data'    => $model,
                ], 200);
        }

        $model->delete();

        return response()->json(
            [
                'message' => 'The data has been deleted.',
                'data'    => $model,
            ], 200);
    }
}
