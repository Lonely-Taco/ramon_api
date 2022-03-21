<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGameRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use XmlResponse\XmlResponse;

class MovieController extends Controller
{
    public function index(Request $request): XmlResponse|JsonResponse|Response
    {
        $acceptedType = $request->getAcceptableContentTypes();

        if (empty($acceptedType)) {
            return response('Bad Request', 400);
        }

        if ($acceptedType[0] === 'application/json') {
            return response()->json(Movie::all(), 200);
        }

        if ($acceptedType[0] === 'application/xml') {
            return response()->xml(Movie::all(), 200);
        }

        return response('Bad Request', 400);
    }

    public function show(Request $request, $id): XmlResponse|JsonResponse|Response
    {
        $acceptedType = $request->getAcceptableContentTypes();

        if (Movie::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        if (empty($acceptedType)) {
            return response('Bad Request', 400);
        }

        if ($acceptedType[0] === 'application/json') {
            return response()->json(Movie::findOrFail($id), 200);
        }

        if ($acceptedType[0] === 'application/xml') {
            return response()->xml(Movie::findOrFail($id), 200);
        }

        return response('Bad Request', 400);
    }

    public function create(UpdateMovieRequest $request): Response
    {
        dump($request->validated());
        exit();
        Movie::create($request->validated());

        return response('OK', 200);
    }

    public function edit($id, UpdateMovieRequest $request): Response
    {
        if (Movie::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        $game = Movie::findOrFail($id);

        $game->update($request->validated());

        $game->save();

        return response('OK', 200);

    }

    public function destroy($id): Response
    {
        if (Movie::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        $game = Movie::findOrFail($id);

        $game->delete();

        return response('No Content', 204);
    }
}
