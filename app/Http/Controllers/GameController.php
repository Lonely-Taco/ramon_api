<?php

namespace App\Http\Controllers;

use App\Contracts\JsonGameValidatorInterface;
use App\Contracts\XmlGameValidatorInterface;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use XmlResponse\XmlResponse;

class GameController extends Controller
{
    public function __construct(
        protected XmlGameValidatorInterface $APIXmlValidator,
        protected JsonGameValidatorInterface $jsonGameValidator,
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

        if ($request->wantsJson()) {


            return response()->json($model, 200);
        }

        return response('Bad Request', 400);
    }

    /**
     * @param UpdateGameRequest $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(
        JsonGameValidatorInterface $jsonGameValidator,
        XmlGameValidatorInterface $gameXmlValidator,
        UpdateGameRequest $request
    ): XmlResponse|JsonResponse|Response
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

            $data = $request->all();

            $validated = $jsonGameValidator->processCreate($data);

            return response()->json(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        return response('No Data', 204);
    }

    /**
     * @param JsonGameValidatorInterface $jsonGameValidator
     * @param int $id
     * @param UpdateGameRequest $request
     * @param XmlGameValidatorInterface $gameXmlValidator
     * @return XmlResponse|JsonResponse|Response
     */
    public function edit(
        JsonGameValidatorInterface $jsonGameValidator,
        int $id, UpdateGameRequest $request,
        XmlGameValidatorInterface $gameXmlValidator
    ): XmlResponse|JsonResponse|Response
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

            $data = $request->all();

            $validated = $jsonGameValidator->processEdit($data, $id);

            return response()->json(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
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
