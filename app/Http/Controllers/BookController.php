<?php

namespace App\Http\Controllers;

use App\Contracts\XmlBookValidatorInterface;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use XmlResponse\XmlResponse;

class BookController extends Controller
{
    public function __construct(
        protected XmlBookValidatorInterface $bookXmlValidator
    )
    {
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
                    'data' => Book::all(),
                ], 200);
        }

        if ($request->wantsXml()) {
            return response()->xml(
                [
                    'data' => Book::all(),
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

            if (Book::where('id', $id)->doesntExist()) {
                return response()->xml(
                    ['message' => 'The data with the following id was not found',
                     'data'    => $id,
                    ], 404);
            }

            $result = ArrayToXml::convert(Book::findOrFail($id)->toArray());

            $xml = new DOMDocument();
            $xml->loadXML($result, LIBXML_NOBLANKS); // Or load if filename required
            if (! $xml->schemaValidate(storage_path('data/schemas_xml/bookDefinition.xsd'))) // Or schemaValidateSource if string used.
            {
                return response('Bad Request', 400);
            }

            return response()->xml(Book::findOrFail($id), 200);
        }

        if ($request->wantsJson()) {

        }

        return response('Bad Request', 400);
    }

    /**
     * @param UpdateBookRequest $request
     * @return Response
     */
    public function create(XmlBookValidatorInterface $bookXmlValidator, UpdateBookRequest $request): Response
    {
        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $validated = $bookXmlValidator->processCreate($requestXml);

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);

        }
        return response('OK', 200);
    }

    /**
     * @param int $id
     * @param UpdateBookRequest $request
     * @return Response
     */
    public function edit(XmlBookValidatorInterface $bookXmlValidator, int $id, UpdateBookRequest $request): Response
    {
        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $validated = $bookXmlValidator->processEdit($requestXml, $id);

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
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

            $book = Book::findOrFail($id);

            $book->delete();

            return response()->xml(
                [
                    'message' => 'The data has been deleted.',
                    'data'    => $book,
                ], 200);
        }

        if ($request->wantsJson()) {

        }

        return response('No Content', 204);
    }
}
