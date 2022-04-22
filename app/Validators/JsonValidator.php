<?php

namespace App\Validators;

use JsonSchema\Validator;

abstract class JsonValidator
{
    public function __construct(
        protected string $schemaPath,
        protected string $model,
    )
    {
    }

    /**
     * Validate the creation of an object
     *
     * @param array $data
     * @return array
     */
    public function processCreate(array $data): array
    {
        $validator = $this->validateJson($data);

        if ($validator->isValid()) {
            $instance = new $this->model();

            return
                ['message' => 'The data has been inserted.',
                 'data'    => $instance::create($data),
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
     *
     * @param array $data
     * @param int $id
     * @return array
     */
    public function processEdit(array $data, int $id): array
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


        $validator = $this->validateJson($data);

        if ($validator->isValid()) {

            $instance      = new $this->model();
            $instanceModel = $instance::findOrFail($id);
            $instanceModel->update($data);
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

        $jsonData = Validator::arrayToObjectRecursive($this->convertToInteger($data));

        $validator->validate($jsonData, (object) ['$ref' => $this->schemaPath]);

        return $validator;

    }

    /**
     * some variables were turned to strings
     * this casts them back to integers
     *
     * @param array $data
     * @return array
     */
    protected function convertToInteger(array $data): array
    {
        if (array_key_exists('positive_ratings', $data)) {
            $data['positive_ratings'] = $data['positive_ratings'] != null ? (int) $data['positive_ratings'] : $data['positive_ratings'];
        }

        if (array_key_exists('negative_ratings', $data)) {
            $data['negative_ratings'] = $data['negative_ratings'] != null ? (int) $data['negative_ratings'] : $data['negative_ratings'];
        }

        if (array_key_exists('year', $data)) {
            $data['year'] = $data['year'] != null ? (int) $data['year'] : $data['year'];
        }

        if (array_key_exists('iMDb', $data)) {
            $data['iMDb'] = $data['iMDb'] != null ? (int) $data['iMDb'] : $data['iMDb'];
        }

        if (array_key_exists('runtime', $data)) {
            $data['runtime'] = $data['runtime'] != null ? (int) $data['runtime'] : $data['runtime'];
        }

        if (array_key_exists('average_rating', $data)) {
            $data['average_rating'] = $data['average_rating'] != null ? (int) $data['average_rating'] : $data['average_rating'];
        }
        if (array_key_exists('ratings_count', $data)) {
            $data['ratings_count'] = $data['ratings_count'] != null ? (int) $data['ratings_count'] : $data['ratings_count'];
        }
        if (array_key_exists('publication_date', $data)) {
            $data['publication_date'] = $data['publication_date'] != null ? (int) $data['publication_date'] : $data['publication_date'];
        }

        return $data;
    }
}
