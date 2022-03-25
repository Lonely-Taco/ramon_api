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

/**
 * @OA\PathItem (
 *  path="app/Http/Controllers"
 *     )
 *
 */
class MovieController extends Controller
{
    public function __construct(
        protected XmlMovieValidatorInterface $movieXmlValidator,
        protected JsonMovieValidatorInterface $movieJsonValidator
    )
    {
    }

    /**
     * @OA\Get(
     *      path="/api/movies",
     *      operationId="movieIndex",
     *      tags={"Movie"},
     *      summary="Get all movies",
     *      description="Returns all movies",
     *      @OA\Response(
     *          response=200,
     *          description="Movies"
     *       )
     *     )
     *
     * Returns list of Movies
     *
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function index(Request $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            return response()->xml(
                [
                    'data' => Movie::all(),
                ], 200);

        }

        return response()->json(
            [
                'data' => Movie::all(),
            ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/movie/id={id}",
     *      operationId="showMovies",
     *      tags={"Movie"},
     *      summary="Get movie by index",
     *      description="Returns a movie by the given id",
     *      @OA\Parameter(
     *          name="id",
     *          description="Movie id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Movie"
     *       )
     *     )
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

        return response()->json($model, 200);
    }

    /**
     * @OA\Post(
     *      path="/api/movie/",
     *      operationId="createMovie",
     *      tags={"Movie"},
     *      summary="Creates and returns a movie object",
     *      description="Creates and returns a movie",
     *
     *     @OA\Parameter(
     *          name="title",
     *          description="Movie title",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="year",
     *          description="Year the movie was released",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="iMDb",
     *          description="average rating",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *     @OA\Parameter(
     *          name="runtime",
     *          description="movie duration in mintues",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *      @OA\Response(
     *          response=200,
     *          description="sucess"
     *       ),
     *     @OA\Response(
     *          response=422,
     *          description="Unproccessed data"
     *       ),
     *     @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *
     *)
     * Creates and returns a movie object
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

        $data = $request->all();

        $validated = $movieJsonValidator->processCreate($data);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }

    /**
     * * @OA\Patch (
     *      path="/api/movie/id={id}",
     *      operationId="editMovie",
     *      tags={"Movie"},
     *      summary="Updates and returns a movie object",
     *      description="Updates and returns a movie",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     * @OA\Parameter(
     *          name="title",
     *          description="Movie title",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
     * @OA\Parameter(
     *          name="year",
     *          description="Year the movie was released",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     * @OA\Parameter(
     *          name="iMDb",
     *          description="average rating",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     * @OA\Parameter(
     *          name="runtime",
     *          description="movie duration in mintues",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *      @OA\Response(
     *          response=200,
     *          description="sucess"
     *       ),
     *     @OA\Response(
     *          response=422,
     *          description="Unproccessed data"
     *       ),
     *     @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Updates and returns a movie object
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


        $data = $request->all();

        $validated = $movieJsonValidator->processEdit($data, $id);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }

    /**
     * @OA\Delete (
     *      path="/api/movie/id={id}",
     *      operationId="destroyMovie",
     *      tags={"Movie"},
     *      summary="Delete a movie",
     *      description="Delete a movie with the given id",
     *
     *     @OA\Parameter(
     *          name="id",
     *          description="Movie id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Delete a movie with the given id
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


        $model->delete();

        return response()->json(
            [
                'message' => 'The data has been deleted.',
                'data'    => $model,
            ], 200);


    }
}
