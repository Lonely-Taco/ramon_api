<?php

namespace App\Http\Controllers;

use App\Contracts\JsonMovieValidatorInterface;
use App\Contracts\JsonTagValidatorInterface;
use App\Contracts\XmlMovieValidatorInterface;
use App\Contracts\XmlTagValidatorInterface;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use XmlResponse\XmlResponse;

/**
 * @OA\PathItem (
 *  path="app/Http/Controllers"
 *     )
 *
 */
class TagController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/tags",
     *      operationId="tagIndex",
     *      tags={"Tag"},
     *      summary="Get all tags",
     *      description="Returns all tags",
     *      @OA\Response(
     *          response=200,
     *          description="Tags"
     *       )
     *     )
     *
     * Returns list of Tags
     *
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function index(Request $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            return response()->xml(
                [
                    'data' => Tag::all(),
                ], 200);

        }

        return response()->json(
            [
                'data' => Tag::all(),
            ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/tags/getMovieTags",
     *      operationId="getMovieTags",
     *      tags={"Tag"},
     *      summary="Get all movie tags",
     *      description="Returns all movie tags",
     *      @OA\Response(
     *          response=200,
     *          description="Tags"
     *       )
     *     )
     *
     * Returns list of Tags
     *
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function movieTags(Request $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            return response()->xml(
                [
                    'data' => Tag::whereHas('movies')->get(),
                ], 200);

        }

        return response()->json(
            [
                'data' => Tag::whereHas('movies')->get()
            ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/tags/getGameTags",
     *      operationId="getGameTags",
     *      tags={"Tag"},
     *      summary="Get all game tags",
     *      description="Returns all game tags",
     *      @OA\Response(
     *          response=200,
     *          description="Tags"
     *       )
     *     )
     *
     * Returns list of Tags
     *
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function gameTags(Request $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            return response()->xml(
                [
                    'data' => Tag::whereHas('games')->get(),
                ], 200);

        }

        return response()->json(
            [
                'data' => Tag::whereHas('games')->get(),
            ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/tags/getBookTags",
     *      operationId="getBookTags",
     *      tags={"Tag"},
     *      summary="Get all book tags",
     *      description="Returns all book tags",
     *      @OA\Response(
     *          response=200,
     *          description="Tags"
     *       )
     *     )
     *
     * Returns list of Tags
     *
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function bookTags(Request $request): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            return response()->xml(
                [
                    'data' => Tag::whereHas('books')->get(),
                ], 200);

        }

        return response()->json(
            [
                'data' => Tag::whereHas('books')->get(),
            ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/tag/{id}",
     *      operationId="showTags",
     *      tags={"Tag"},
     *      summary="Get tag by index",
     *      description="Returns a tag by the given id",
     *      @OA\Parameter(
     *          name="id",
     *          description="Tag id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Tag"
     *       )
     *     )
     * @param Request $request
     * @param int $id
     * @return XmlResponse|JsonResponse|Response
     */
    public function show(Request $request, int $id): XmlResponse|JsonResponse|Response
    {
        if (Tag::where('id', $id)->doesntExist()) {
            return response()->json(
                ['message' => 'The data with the following id was not found',
                 'data'    => $id,
                ], 404);
        }

        $model = Tag::findOrFail($id);


        if ($request->wantsXml()) {

            return response()->xml($model, 200);
        }

        return response()->json($model, 200);
    }

    /**
     * @OA\Post (
     *      path="/api/tag",
     *      operationId="createTag",
     *      tags={"Tag"},
     *      summary="Creates and returns a tag object",
     *      description="Creates and returns a tag",
     *
     *     @OA\Parameter(
     *          name="name",
     *          description="Tag name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
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
     * Creates and returns a tag object
     * @param JsonTagValidatorInterface $tagJsonValidator
     * @param XmlTagValidatorInterface $tagXmlValidator
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(
        JsonTagValidatorInterface $tagJsonValidator,
        XmlTagValidatorInterface $tagXmlValidator,
        Request $request,
    ): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {
            $validated = $tagXmlValidator->processCreate($request->getContent());
            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }

        $validated = $tagJsonValidator->processCreate($request->getContent());

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }

    /**
     * * @OA\Patch (
     *      path="/api/tag/{id}",
     *      operationId="editTag",
     *      tags={"Tag"},
     *      summary="Updates and returns a tag object",
     *      description="Updates and returns a tag",
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
     *          name="name",
     *          description="Tag name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *            ),
     *         ),
     *
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
     * Updates and returns a tag object
     * @param XmlTagValidatorInterface $tagXmlValidator
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function edit(
        JsonTagValidatorInterface $tagJsonValidator,
        XmlTagValidatorInterface $tagXmlValidator,
        int $id,
        Request $request,
    ): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {
            $validated = $tagXmlValidator->processEdit($request->getContent(), $id);
            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }


        $validated = $tagJsonValidator->processEdit($request->getContent(), $id);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }

    /**
     * @OA\Delete (
     *      path="/api/tag/{id}",
     *      operationId="destroyTag",
     *      tags={"Tag"},
     *      summary="Delete a tag",
     *      description="Delete a tag with the given id",
     *
     *     @OA\Parameter(
     *          name="id",
     *          description="Tag id",
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
     * Delete a tag with the given id
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function destroy(int $id, Request $request): XmlResponse|JsonResponse|Response
    {
        if (Tag::where('id', $id)->doesntExist()) {
            return response(
                [
                    'message' => 'The data with the following id was not found',
                    'data'    => $id,
                ], 404);
        }

        $model = Tag::findOrFail($id);

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

//    /**
//     * * @OA\Post (
//     *      path="/api/tags/movie/{id}",
//     *      operationId="tagMovie",
//     *      tags={"Tag"},
//     *      summary="add a tag to a movie",
//     *      description="add tag",
//     *      @OA\Parameter(
//     *          name="id",
//     *          description="id",
//     *          required=true,
//     *          in="path",
//     *          @OA\Schema(
//     *              type="integer"
//     *            ),
//     *         ),
//     *
//     * @OA\Parameter(
//     *          name="tag id",
//     *          description="Id of the tag",
//     *          required=true,
//     *          in="query",
//     *          @OA\Schema(
//     *              type="id"
//     *            ),
//     *         ),
//     *
//     *      @OA\Response(
//     *          response=200,
//     *          description="sucess"
//     *       ),
//     *     @OA\Response(
//     *          response=422,
//     *          description="Unproccessed data"
//     *       ),
//     *     @OA\Response(
//     *          response=204,
//     *          description="No content"
//     *       ),
//     *     @OA\Response(
//     *          response=404,
//     *          description="Not found"
//     *       ),
//     *)
//     * tags and returns movie object
//     * @param JsonTagValidatorInterface $tagJsonValidator
//     * @param XmlTagValidatorInterface $tagXmlValidator
//     * @param int $id
//     * @param Request $request
//     * @return XmlResponse|JsonResponse|Response
//     */
//    public function tag(
//        JsonTagValidatorInterface $tagJsonValidator,
//        XmlTagValidatorInterface $tagXmlValidator,
//        int $id,
//        Request $request,
//    ): XmlResponse|JsonResponse|Response
//    {
//        if ($request->wantsXml()) {
//            $validated = $tagXmlValidator->processTag($request->getContent(), $id);
//            return response()->xml(
//                [
//                    'message' => $validated['message'],
//                    'data'    => $validated['data'],
//                ], $validated['code']);
//        }
//
//
//        $validated = $tagJsonValidator->processTag($request->getContent(), $id);
//
//        return response()->json(
//            [
//                'message' => $validated['message'],
//                'data'    => $validated['data'],
//            ], $validated['code']);
//
//    }
}
