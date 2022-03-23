<?php

namespace App\Http\Controllers;

use App\Contracts\JsonMovieValidatorInterface;
use App\Contracts\XmlMovieValidatorInterface;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use XmlResponse\XmlResponse;

class MovieController extends Controller
{
    public function __construct(
        protected XmlMovieValidatorInterface $movieXmlValidator,
        protected JsonMovieValidatorInterface $movieJsonValidator
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
        if (Movie::where('id', $id)->doesntExist()) {
            return response()->json(
                ['message' => 'The data with the following id was not found',
                 'data'    => $id,
                ], 404);
        }

        $model = Movie::findOrFail($id);


        if ($request->wantsXml()) {

            return response()->xml($model, 200);
        }

        if ($request->wantsJson()) {


            return response()->json($model, 200);
        }

        return response('Bad Request', 400);
    }

    /**
     * @param JsonMovieValidatorInterface $movieJsonValidator
     * @param XmlMovieValidatorInterface $movieXmlValidator
     * @param UpdateMovieRequest $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(
        JsonMovieValidatorInterface $movieJsonValidator,
        XmlMovieValidatorInterface $movieXmlValidator,
        UpdateMovieRequest $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            $requestXml = ArrayToXml::convert($request->all());

            $validated = $movieXmlValidator->processCreate($requestXml);

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        if ($request->wantsJson()) {
            $data = $request->all();

            $validated = $movieJsonValidator->processCreate($data);

            return response()->json(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        return response('', 204);
    }

    /**
     * @param XmlMovieValidatorInterface $movieXmlValidator
     * @param int $id
     * @param UpdateMovieRequest $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function edit(
        JsonMovieValidatorInterface $movieJsonValidator,
        XmlMovieValidatorInterface $movieXmlValidator,
        int $id, UpdateMovieRequest $request): XmlResponse|JsonResponse|Response
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

        if ($request->wantsJson()) {

            $data = $request->all();

            $validated = $movieJsonValidator->processEdit($data, $id);

            return response()->json(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        return response('', 204);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function destroy(int $id, Request $request): XmlResponse|JsonResponse|Response
    {
        if (Movie::where('id', $id)->doesntExist()) {
            return response(
                [
                    'message' => 'The data with the following id was not found',
                    'data'    => $id,
                ], 404);
        }

        $model = Movie::findOrFail($id);

        if ($request->wantsXml()) {

            $model->delete();

            return response()->xml(
                [
                    'message' => 'The data has been deleted.',
                    'data'    => $model,
                ], 200);
        }

        if ($request->wantsJson()) {

            $model->delete();

            return response()->json(
                [
                    'message' => 'The data has been deleted.',
                    'data'    => $model,
                ], 200);
        }

        return response('No Content', 204);
    }
}
