<?php

namespace App\Http\Controllers;

use App\Contracts\JsonBookValidatorInterface;
use App\Contracts\XmlBookValidatorInterface;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use XmlResponse\XmlResponse;

/**
 * @OA\PathItem (
 *  path="app/Http/Controllers"
 *     )
 */
class BookController extends Controller
{
    public function __construct(
        protected XmlBookValidatorInterface $bookXmlValidator,
        protected JsonBookValidatorInterface $bookJsonValidator,
    )
    {
    }

    /**
     * @OA\Get(
     *      path="/api/books",
     *      operationId="bookIndex",
     *      tags={"Book"},
     *      summary="Get all books",
     *      description="Returns all books",
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Returns list of Books
     *
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function index(Request $request): XmlResponse|JsonResponse|Response
    {

        if ($request->wantsXml()) {
            return response()->xml(
                [
                    'data' => Book::all(),
                ], 200);
        }


        return response()->json(
            [
                'data' => Book::all(),
            ], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/book/{id}",
     *      operationId="showBooks",
     *      tags={"Book"},
     *      summary="Get book by index",
     *      description="Returns a book by the given id",
     *      @OA\Parameter(
     *          name="id",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *       ),
     *)
     * Returns a book by index
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

        return response()->json($model, 200);
    }

    /**
     * @OA\Post(
     *      path="/api/book",
     *      operationId="createBook",
     *      tags={"Book"},
     *      summary="Creates and returns a book object",
     *      description="Creates and returns a book",
     *
     *      @OA\RequestBody (
     *          description="Update a Book object",
     *          required=true,
     *
     *       @OA\JsonContent(
     *          @OA\Schema(
     *              ref="#/components/schemas/Book"
     *              ),
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success"
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
     * Creates and returns a book object
     * @param JsonBookValidatorInterface $bookJsonValidator
     * @param XmlBookValidatorInterface $bookXmlValidator
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function create(JsonBookValidatorInterface $bookJsonValidator,
        XmlBookValidatorInterface $bookXmlValidator,
        Request $request,
    ): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {

            $validated = $bookXmlValidator->processCreate($request->getContent());

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);

        }

        $validated = $bookJsonValidator->processCreate($request->getContent());

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);
    }

    /**
     * @OA\Put (
     *      path="/api/book/{id}",
     *      operationId="editBook",
     *      tags={"Book"},
     *      summary="Updates and returns a book object",
     *      description="Updates and returns a book",
     *
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
     *      @OA\RequestBody (
     *          description="Update a Book object ID not required",
     *          required=true,
     *
     *       @OA\JsonContent(
     *          @OA\Schema(
     *              ref="#/components/schemas/Book"
     *              ),
     *            ),
     *         ),
     *      @OA\Response(
     *          response=200,
     *          description="success"
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
     *     )
     *
     * Updates and returns a book object
     * @param JsonBookValidatorInterface $bookJsonValidator
     * @param XmlBookValidatorInterface $bookXmlValidator
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function edit(
        JsonBookValidatorInterface $bookJsonValidator,
        XmlBookValidatorInterface $bookXmlValidator,
        int $id,
        Request $request,
    ): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {
            $validated = $bookXmlValidator->processEdit($request->getContent(), $id);

            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }


        $validated = $bookJsonValidator->processEdit($request->getContent(), $id);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);
    }

    /**
     * @OA\Delete (
     *      path="/api/book/{id}",
     *      operationId="destroyBook",
     *      tags={"Book"},
     *      summary="Delete a book",
     *      description="Delete a book with the given id",
     *
     *     @OA\Parameter(
     *          name="id",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Books"
     *       ),
     *     @OA\Response(
     *          response=204,
     *          description="No content"
     *       ),
     *     @OA\Response(
     *          response=404,
     *          description="No content"
     *       ),
     *     )
     *
     * Delete a book with the given id
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

    /**
     * * @OA\Post (
     *      path="/api/book/giveTag/{id}",
     *      operationId="tagBook",
     *      tags={"Book"},
     *      summary="add a tag to a book",
     *      description="add tag",
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
     *      @OA\RequestBody (
     *          description="Tag object",
     *          required=true,
     *
     *       @OA\JsonContent(
     *          @OA\Schema(
     *              ref="#/components/schemas/Tag"
     *              ),
     *            ),
     *         ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="success"
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
     * tags a book and returns a collection of tags
     * @param JsonBookValidatorInterface $bookJsonValidator
     * @param XmlBookValidatorInterface $bookXmlValidator
     * @param int $id
     * @param Request $request
     * @return XmlResponse|JsonResponse|Response
     */
    public function tag(
        JsonBookValidatorInterface $bookJsonValidator,
        XmlBookValidatorInterface $bookXmlValidator,
        int $id,
        Request $request,
    ): XmlResponse|JsonResponse|Response
    {
        if ($request->wantsXml()) {
            $validated = $bookXmlValidator->processTag($request->getContent(), $id);
            return response()->xml(
                [
                    'message' => $validated['message'],
                    'data'    => $validated['data'],
                ], $validated['code']);
        }


        $validated = $bookJsonValidator->processTag($request->getContent(), $id);

        return response()->json(
            [
                'message' => $validated['message'],
                'data'    => $validated['data'],
            ], $validated['code']);

    }
}
