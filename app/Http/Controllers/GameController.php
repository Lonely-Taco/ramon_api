<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use XmlResponse\XmlResponse;

class GameController extends Controller
{
    public function index(Request $request): XmlResponse|JsonResponse|Response
    {
        $acceptedType = $request->getAcceptableContentTypes();

        if (empty($acceptedType)) {
            return response('Bad Request', 400);
        }

        if ($acceptedType[0] === 'application/json') {
            return response()->json(Game::all(), 200);
        }

        if ($acceptedType[0] === 'application/xml') {
            return response()->xml(Game::all(), 200);
        }

        return response('Bad Request', 400);
    }

    public function show(Request $request, $id): XmlResponse|JsonResponse|Response
    {
        $acceptedType = $request->getAcceptableContentTypes();

        if (Game::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        if (empty($acceptedType)) {
            return response('Bad Request', 400);
        }

        if ($acceptedType[0] === 'application/json') {
            return response()->json(Game::findOrFail($id), 200);
        }

        if ($acceptedType[0] === 'application/xml') {
            $xml = new DOMDocument();
            $xml->loadXML('A string goes here containing the XML data ', LIBXML_NOBLANKS); // Or load if filename required
            if (! $xml->schemaValidate('file name for the XSD file ')) // Or schemaValidateSource if string used.
            {
            }
            return response()->xml(Game::findOrFail($id), 200);
        }

        return response('Bad Request', 400);
    }

    public function create(UpdateGameRequest $request): Response
    {
        $game = Game::create($request->validated());

        return response($game, 200);
    }

    public function edit($id, UpdateGameRequest $request): Response
    {
        if (Game::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        $game = Game::findOrFail($id);

        $game->update($request->validated());

        $game->save();

        return response($game, 200);

    }

    public function destroy($id): Response
    {
        if (Game::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        $game = Game::findOrFail($id);

        $game->delete();

        return response('No Content', 204);
    }
}
