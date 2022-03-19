<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use XmlResponse\XmlResponse;

class BookController extends Controller
{
    public function index(Request $request): XmlResponse|JsonResponse|Response
    {
        $acceptedType = $request->getAcceptableContentTypes();

        if (empty($acceptedType)) {
            return response('Bad Request', 400);
        }

        if ($acceptedType[0] === 'application/json') {
            return response()->json(Book::all(), 200);
        }

        if ($acceptedType[0] === 'application/xml') {
            return response()->xml(Book::all(), 200);
        }

        return response('Bad Request', 400);
    }

    public function show(Request $request, $id): XmlResponse|JsonResponse|Response
    {
        $acceptedType = $request->getAcceptableContentTypes();

        if (Book::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        if (empty($acceptedType)) {
            return response('Bad Request', 400);
        }

        if ($acceptedType[0] === 'application/json') {
            return response()->json(Book::findOrFail($id), 200);
        }

        if ($acceptedType[0] === 'application/xml') {
            return response()->xml(Book::findOrFail($id), 200);
        }

        return response('Bad Request', 400);
    }

    public function create(UpdateBookRequest $request): Response
    {
        Book::create($request->validated());

        return response('OK', 200);
    }

    public function edit($id, UpdateBookRequest $request): Response
    {
        if (Book::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        $game = Book::findOrFail($id);

        $game->update($request->validated());

        $game->save();

        return response('OK', 200);

    }

    public function destroy($id): Response
    {
        if (Book::where('id', $id)->doesntExist()) {
            return response('not found', 404);
        }

        $game = Book::findOrFail($id);

        $game->delete();

        return response('No Content', 204);
    }
}
