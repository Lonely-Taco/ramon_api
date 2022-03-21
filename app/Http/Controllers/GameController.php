<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use Xml;
use XmlResponse\XmlResponse;

class GameController extends Controller
{
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

            $result = ArrayToXml::convert(Game::findOrFail($id)->toArray());

            $xml = new DOMDocument();
            $xml->loadXML($result, LIBXML_NOBLANKS);

            if (! $xml->schemaValidate(storage_path('data/schemas_xml/gameDefinition.xsd'))) {
                return response('Bad Request', 400);
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
    public function create(UpdateGameRequest $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $errors = Xml::validate($requestXml, storage_path('data/schemas_xml/gameDefinition.xsd'));

            if ($errors) {
                return response()->xml([
                    'message' => 'The data was invalid.',
                    'errors'  => $errors,
                ], 422);
            }

            return response()->xml(
                ['message' => 'The data has been inserted.',
                 'data'    => Game::create($request->validated()),
                ], 200);
        }

        if ($request->wantsJson()) {

        }

        return response('OK', 200);
    }

    /**
     * @param int $id
     * @param UpdateGameRequest $request
     * @return Response
     */
    public function edit(int $id, UpdateGameRequest $request): Response
    {
        if ($request->wantsXml()) {

            if (Game::where('id', $id)->doesntExist()) {
                return response()->xml(
                    ['message' => 'The data with the following id was not found',
                     'data'    => $id,
                    ], 404);
            }

            $requestXml = ArrayToXml::convert($request->all());

            $errors = Xml::validate($requestXml, storage_path('data/schemas_xml/gameDefinition.xsd'));

            if ($errors) {
                return response()->xml([
                    'message' => 'The data was invalid.',
                    'errors'  => $errors,
                ], 422);
            }

            $game = Game::findOrFail($id);
            $game->update($request->validated());
            $game->save();

            return response()->xml(
                ['message' => 'The data has been inserted.',
                 'data'    => $game,
                ], 200);
        }

        if ($request->wantsJson()) {

        }

        return response('Not found', 404);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function destroy(int $id, Request $request): Response
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

        }

        return response('No Content', 204);
    }
}
