<?php

namespace App\Http\Controllers;

use App\Contracts\XmlMovieValidatorInterface;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use Xml;
use XmlResponse\XmlResponse;

class MovieController extends Controller
{
    public function __construct(
        protected XmlMovieValidatorInterface $movieXmlValidator
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
                    'data' => Movie::all(),
                ], 200);
        }

        if ($request->wantsXml()) {
            return response()->xml(
                [
                    'data' => Movie::all(),
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

            if (Movie::where('id', $id)->doesntExist()) {
                return response()->xml(
                    ['message' => 'The data with the following id was not found',
                     'data'    => $id,
                    ], 404);
            }

            $result = ArrayToXml::convert(Movie::findOrFail($id)->toArray());

            $xml = new DOMDocument();
            $xml->loadXML($result, LIBXML_NOBLANKS);

            if (! $xml->schemaValidate(storage_path('data/schemas_xml/movieDefinition.xsd'))) {
                return response('Bad Request', 400);
            }

            return response()->xml(Movie::findOrFail($id), 200);
        }

        if ($request->wantsJson()) {

        }

        return response('Bad Request', 400);
    }

    /**
     * @param UpdateMovieRequest $request
     * @return Response
     */
    public function create(UpdateMovieRequest $request): Response
    {
        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $errors = Xml::validate($requestXml, storage_path('data/schemas_xml/movieDefinition.xsd'));

            if ($errors) {
                return response()->xml([
                    'message' => 'The data was invalid.',
                    'errors'  => $errors,
                ], 422);
            }

            return response()->xml(
                ['message' => 'The data has been inserted.',
                 'data'    => Movie::create($request->validated()),
                ], 200);
        }

        if ($request->wantsJson()) {

        }

        return response('OK', 200);
    }

    /**
     * @param int $id
     * @param UpdateMovieRequest $request
     * @return Response
     */
    public function edit(XmlMovieValidatorInterface $movieXmlValidator ,int $id, UpdateMovieRequest $request): Response
    {
        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $validated = $movieXmlValidator->processEdit($requestXml, $id);

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
     * @param Request $request
     * @return Response
     */
    public function destroy(int $id, Request $request): Response
    {
        if ($request->wantsXml()) {

            if (Movie::where('id', $id)->doesntExist()) {
                return response()->xml(
                    [
                        'message' => 'The data with the following id was not found',
                        'data'    => $id,
                    ], 404);
            }

            $movie = Movie::findOrFail($id);

            $movie->delete();

            return response()->xml(
                [
                    'message' => 'The data has been deleted.',
                    'data'    => $movie,
                ], 200);
        }

        if ($request->wantsJson()) {

        }

        return response('No Content', 204);
    }
}
