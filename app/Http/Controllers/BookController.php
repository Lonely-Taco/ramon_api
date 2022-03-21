<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use Xml;
use XmlResponse\XmlResponse;

class BookController extends Controller
{
    /**
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
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

    /**
     * @param Request $request
     * @param int $id
     * @return XmlResponse|JsonResponse|Response
     */
    public function show(Request $request, int $id): XmlResponse|JsonResponse|Response
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

        if ($request->wantsXml()) {

            $result = ArrayToXml::convert(Book::findOrFail($id)->toArray());

            $xml = new DOMDocument();
            $xml->loadXML($result, LIBXML_NOBLANKS); // Or load if filename required
            if (! $xml->schemaValidate(storage_path('data/schemas_xml/bookDefinition.xsd'))) // Or schemaValidateSource if string used.
            {
                return response('Bad Request', 400);
            }

            return response()->xml(Book::findOrFail($id), 200);
        }

        return response('Bad Request', 400);
    }

    /**
     * @param UpdateBookRequest $request
     * @return Response
     */
    public function create(UpdateBookRequest $request): Response
    {
        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $errors = Xml::validate($requestXml, storage_path('data/schemas_xml/bookDefinition.xsd'));

            if ($errors) {
                return response()->xml([
                    'message' => 'The data was invalid.',
                    'errors'  => $errors,
                ], 422);
            }

            $attributes = $request->all();

            return response()->xml(
                ['message' => 'The data has been inserted.',
                 'data'    => Book::create($request->validated()),
                ], 200);
        }
        return response('OK', 200);
    }

    /**
     * @param int $id
     * @param UpdateBookRequest $request
     * @return Response
     */
    public function edit(int $id, UpdateBookRequest $request): Response
    {
        if ($request->wantsXml()) {

            if (Book::where('id', $id)->doesntExist()) {
                return response()->xml(
                    ['message' => 'The data with the following id was not found',
                     'data'    => $id,
                    ], 404);
            }

            $requestXml = ArrayToXml::convert($request->all());

            $errors = Xml::validate($requestXml, storage_path('data/schemas_xml/bookDefinition.xsd'));

            if ($errors) {
                return response()->xml([
                    'message' => 'The data was invalid.',
                    'errors'  => $errors,
                ], 422);
            }

            $game = Book::findOrFail($id);
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

            if (Book::where('id', $id)->doesntExist()) {
                return response()->xml(
                    [
                        'message' => 'The data with the following id was not found',
                        'data'    => $id,
                    ], 404);
            }

            $game = Book::findOrFail($id);

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
