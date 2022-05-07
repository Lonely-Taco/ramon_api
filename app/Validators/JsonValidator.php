<?php

namespace App\Validators;

use App\Models\Tag;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use JsonSchema\Validator;

abstract class JsonValidator
{
    public function __construct(
        protected string $schemaPath,
        protected string $tagSchemaPath,
        protected string $model,
    )
    {
    }

    /**
     * Validate the creation of an object
     */
    public function processCreate(string $data): array
    {
        $jsonData = json_decode($data, true);

        // remove possible ids fields.
        $cleanJson = Arr::except($jsonData, ['confirm-password']);

        if ($cleanJson == null) {
            return [
                'message' => 'Bad Request; Body is null or properties are missing',
                'data'    => $jsonData,
                'code'    => 400,
            ];
        }

        $validator = $this->validateJson($jsonData);

        if ($validator->isValid()) {
            $instance = new $this->model();

            return
                ['message' => 'The data has been inserted.',
                 'data'    => $instance::create($jsonData),
                 'code'    => 200,
                ];
        }

        return [
            'message' => 'The data was invalid.',
            'data'    => $validator->getErrors(),
            'code'    => 422,
        ];
    }

    /**
     * Validate the update of an object
     */
    public function processEdit(string $data, int $id): array
    {
        $instance = new $this->model();

        if ($instance::where('id', $id)->doesntExist()) {
            return
                [
                    'message' => 'The data with the following id was not found',
                    'data'    => $id,
                    'code'    => 404,
                ];
        }

        $jsonData = json_decode($data, true);

        if ($jsonData == null){
             return   [
                    'message' => 'Bad Request; Body is null or properties are missing',
                    'data'    => $jsonData,
                    'code'    => 400,
                ];
        }

        $validator = $this->validateJson($jsonData);

        if ($validator->isValid()) {
            $instance      = new $this->model();
            $instanceModel = $instance::findOrFail($id);
            $instanceModel->update($jsonData);
            $instanceModel->save();

            return
                ['message' => 'The data has been inserted.',
                 'data'    => $instanceModel,
                 'code'    => 200,
                ];
        }

        return [
            'message' => 'The data was invalid.',
            'data'    => $validator->getErrors(),
            'code'    => 422,
        ];
    }

    /**
     * @param string $data
     * @param int $modelId
     * @return array
     */
    public function processTag(string $data, int $modelId): array
    {
        $instance = new $this->model();

        if ($instance::where('id', $modelId)->doesntExist()) {
            return
                [
                    'message' => 'The data with the following id was not found',
                    'data'    => $modelId,
                    'code'    => 404,
                ];
        }

        $jsonData = json_decode($data, true);

        $validator = new Validator();

        $jsonObject = Validator::arrayToObjectRecursive($jsonData);

        $validator->validate($jsonObject, (object) ['$ref' => $this->tagSchemaPath]);

        if ($validator->isValid()) {

            $tag = Tag::firstOrNew(
                ['id' => $jsonData['id']],
                ['name'=> $jsonData['name']]
            );


            /** @var Model|Taggable $instanceModel */
            $instanceModel = $instance::findOrFail($modelId);

            $instanceModel->tags()->attach([$tag->id]);

            $instanceModel->save();

            return
                ['message' => 'The data has been inserted.',
                 'data'    => $instanceModel,
                 'code'    => 200,
                ];
        }

        return [
            'message' => 'The data was invalid.',
            'data'    => $validator->getErrors(),
            'code'    => 422,
        ];
    }

    /**
     * Validate the json array
     *
     * @param array $data
     * @return Validator
     */
    protected function validateJson(array $data): Validator
    {

        $validator = new Validator();

        $jsonData = Validator::arrayToObjectRecursive($data);

        $validator->validate($jsonData, (object) ['$ref' => $this->schemaPath]);

        return $validator;

    }
}
