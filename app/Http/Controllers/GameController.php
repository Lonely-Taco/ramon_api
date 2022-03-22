<?php

namespace App\Http\Controllers;

use App\Contracts\XmlGameValidatorInterface;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JsonSchema\Validator;
use Spatie\ArrayToXml\ArrayToXml;
use XmlResponse\XmlResponse;

class GameController extends Controller
{
    public function __construct(
      protected XmlGameValidatorInterface $APIXmlValidator
    ) {
    }

    /**
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
     * @param Request $request
     * @param int $id
     * @return XmlResponse|JsonResponse|Response
     */
    public function show(Request $request, int $id): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            if (Game::where('id', $id)->doesntExist()) {
                return response()->xml(
                    ['message' => 'The data with the following id was not found',
                     'data'    => $id,
                    ], 404);
            }

            return response()->xml(Game::findOrFail($id), 200);
        }

        if ($request->wantsJson()) {

        }

        return response('Bad Request', 400);
    }

    /**
     * @param UpdateGameRequest $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(XmlGameValidatorInterface $gameXmlValidator, UpdateGameRequest $request): XmlResponse|JsonResponse|Response
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

        if ($request->wantsJson()) {

        }

        return response('OK', 200);
    }

    /**
     * @param int $id
     * @param UpdateGameRequest $request
     * @param XmlGameValidatorInterface $gameXmlValidator
     * @return XmlResponse|JsonResponse|Response
     */
    public function edit(int $id, UpdateGameRequest $request, XmlGameValidatorInterface $gameXmlValidator): XmlResponse|JsonResponse|Response
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

        if ($request->wantsJson()) {

            if (Game::where('id', $id)->doesntExist()) {
                return response()->json(
                    [
                        'message' => 'The data with the following id was not found',
                        'data'    => $id,
                    ], 404);
            }

            $validator = new Validator();

            $data = $request->all();

            $data['positive_ratings'] = (int) $data['positive_ratings'];
            $data['negative_ratings'] = (int) $data['negative_ratings'];

            $jsonData = Validator::arrayToObjectRecursive($data);

            $validator->validate($jsonData, (object) ['$ref' => storage_path('data/schemas_json/game-schema.json')]);

            if ($validator->isValid()) {

                $game = Game::findOrFail($id);
                $game->update($request->validated());
                $game->save();

                return response()->json(
                    [
                        'message' => 'The data has been inserted.',
                        'data'    => $game,
                    ], 200);

            }

            return response()->json([
                'message' => 'The data was invalid.',
                'errors'  => $validator->getErrors(),
            ], 422);

        }

        return response('Not found', 404);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function destroy(int $id, Request $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            if (Game::where('id', $id)->doesntExist()) {
                return response()->xml(
                    [
                        'message' => 'The data with the following id was not found',
                        'data'    => $id,
                    ], 404);
            }

            $game = Game::findOrFail($id);

            $game->delete();

            return response()->xml(
                [
                    'message' => 'The data has been deleted.',
                    'data'    => $game,
                ], 200);
        }

        if ($request->wantsJson()) {
            if (Game::where('id', $id)->doesntExist()) {
                return response()->json(
                    [
                        'message' => 'The data with the following id was not found',
                        'data'    => $id,
                    ], 404);
            }

            $game = Game::findOrFail($id);

            $game->delete();

            return response()->json(
                [
                    'message' => 'The data has been deleted.',
                    'data'    => $game,
                ], 200);
        }

        return response('No Content', 204);
    }
}
