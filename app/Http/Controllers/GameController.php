<?php

namespace App\Http\Controllers;

use App\Contracts\JsonGameValidatorInterface;
use App\Contracts\XmlGameValidatorInterface;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        config('xml.rowName', 'game');

        if ($request->wantsXml()) {
            return response()->xml(
                [
                    'data' => Game::all(),
                ], 200);
        }

        return response()->json(
            [
                'data' => Game::all(),
            ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/game/{id}",
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
     *          description="success"
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

        return response()->json($model, 200);

    }

    /**
     * @OA\Post(
     *      path="/api/game",
     *      operationId="create",
     *      tags={"Game"},
     *      summary="Creates and returns a game object",
     *      description="Creates and returns a game",
     *
     *      @OA\RequestBody (
     *          description="Create a Game object",
     *          required=true,
     *
     *       @OA\JsonContent(
     *          @OA\Schema(
     *              ref="#/components/schemas/Game"
     *              ),
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Creation Successfull"
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
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(
        JsonGameValidatorInterface $jsonGameValidator,
        XmlGameValidatorInterface $gameXmlValidator,
        Request $request
    ): XmlResponse|JsonResponse|Response
    {
        $validated = match ($request->getContentType()) {
            'json' => $jsonGameValidator->processCreate($request->getContent()),
            'xml' => $gameXmlValidator->processCreate($request->getContent()),
            default => [
                'message' => 'Provide content-type header',
                'data'    => 'Content-Type = ' . $request->getContentType(),
                'code'    => 400,
            ],
        };


        if ($request->wantsXml()) {
            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }

    /**
     * @OA\Put (
     *      path="/api/game/{id}",
     *      operationId="edit",
     *      tags={"Game"},
     *      summary="Edit game",
     *      description="Updates a game Consuming a Game object",
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
     *
     *      @OA\RequestBody (
     *          description="Update a Game object ID not required",
     *          required=true,
     *
     *       @OA\JsonContent(
     *          @OA\Schema(
     *              ref="#/components/schemas/Game"
     *              ),
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Creation Successfull"
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
        int $id,
        Request $request,
        XmlGameValidatorInterface $gameXmlValidator,
    ): XmlResponse|JsonResponse|Response
    {
        $validated = [];

        $validated = match ($request->getContentType()) {
            'json' => $jsonGameValidator->processEdit($request->getContent(), $id),
            'xml' => $gameXmlValidator->processEdit($request->getContent(), $id),
            default => [
                'message' => 'Provide content-type header',
                'data'    => 'Content-Type missing',
                'code'    => 400,
            ],
        };


        if ($request->wantsXml()) {

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);
    }

    /**
     * @OA\Delete (
     *      path="/api/game/{id}",
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

    /**
     * * @OA\Post (
     *      path="/api/game/giveTag/{id}",
     *      operationId="tagGame",
     *      tags={"Game"},
     *      summary="add a tag to a game",
     *      description="add tag",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\RequestBody (
     *          description="Tag object",
     *          required=true,
     *
     *       @OA\JsonContent(
     *          @OA\Schema(
     *              ref="#/components/schemas/Tag"
     *              ),
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success"
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
     * tags a game and returns a collection of tags
     * @param JsonGameValidatorInterface $gameJsonValidator
     * @param XmlGameValidatorInterface $gameXmlValidator
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function tag(
        JsonGameValidatorInterface $gameJsonValidator,
        XmlGameValidatorInterface $gameXmlValidator,
        int $id,
        Request $request,
    ): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {
            $validated = $gameXmlValidator->processTag($request->getContent(), $id);
            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }


        $validated = $gameJsonValidator->processTag($request->getContent(), $id);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }
}
