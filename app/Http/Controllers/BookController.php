<?php

namespace App\Http\Controllers;

use App\Contracts\JsonBookValidatorInterface;
use App\Contracts\XmlBookValidatorInterface;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\ArrayToXml\ArrayToXml;
use XmlResponse\XmlResponse;

class BookController extends Controller
{
    public function __construct(
        protected XmlBookValidatorInterface $bookXmlValidator,
        protected JsonBookValidatorInterface $bookJsonValidator,
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
        if (Book::where('id', $id)->doesntExist()) {
            return response()->json(
                ['message' => 'The data with the following id was not found',
                 'data'    => $id,
                ], 404);
        }

        $model = Book::findOrFail($id);


        if ($request->wantsXml()) {

            return response()->xml($model, 200);
        }

        if ($request->wantsJson()) {


            return response()->json($model, 200);
        }

        return response('Bad Request', 400);
    }

    /**
     * @param JsonBookValidatorInterface $bookJsonValidator
     * @param XmlBookValidatorInterface $bookXmlValidator
     * @param UpdateBookRequest $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(JsonBookValidatorInterface $bookJsonValidator,
        XmlBookValidatorInterface $bookXmlValidator,
        UpdateBookRequest $request
    ): XmlResponse|JsonResponse|Response
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

        if ($request->wantsJson()) {
            $data = $request->all();

            $validated = $bookJsonValidator->processCreate($data);

            return response()->json(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }
        return response('OK', 200);
    }

    /**
     * @param JsonBookValidatorInterface $bookJsonValidator
     * @param XmlBookValidatorInterface $bookXmlValidator
     * @param int $id
     * @param UpdateBookRequest $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function edit(
        JsonBookValidatorInterface $bookJsonValidator,
        XmlBookValidatorInterface $bookXmlValidator,
        int $id, UpdateBookRequest $request
    ): XmlResponse|JsonResponse|Response
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

            $data = $request->all();

            $validated = $bookJsonValidator->processEdit($data, $id);

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
        if (Book::where('id', $id)->doesntExist()) {
            return response(
                [
                    'message' => 'The data with the following id was not found',
                    'data'    => $id,
                ], 404);
        }

        $model = Book::findOrFail($id);

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
