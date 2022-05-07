<?php

namespace App\Validators;

use App\Models\Tag as TagToAppend;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\DocBlock\Tag;
use Xml;

abstract class XmlValidator
{
    public function __construct(
        protected string $schemaPath,
        protected string $tagSchemaPath,
        protected string $model,
    ) {
    }

    /**
     * Validates the creation of an object
     *
     * @param string $xmlString
     * @return array
     */
    public function processCreate(string $xmlString): array
    {
        $validatedArray = $this->validateXmlSchema($xmlString, $this->schemaPath);

        if (array_key_exists('code', $validatedArray)) {
            return $validatedArray;
        }

        $instance = new $this->model();

        return [
            'message' => 'The data has been inserted.',
            'data'    => $instance::create($validatedArray),
            'code'    => 200,
        ];
    }

    /**
     * Validates the update of an object
     *
     * @param string $xmlString
     * @param int $id
     * @return array
     */
    public function processEdit(string $xmlString, int $id): array
    {
        $instance = new $this->model();

        if ($instance::where('id', $id)->doesntExist()) {
            return response()->xml(
                [
                    'message' => 'The data with the following id was not found',
                    'data'    => $id,
                ], 404);
        }

        $validatedArray = $this->validateXmlSchema($xmlString, $this->schemaPath);

        if (array_key_exists('code', $validatedArray)) {
            return $validatedArray;
        }

        $instance = new $this->model();
        $instanceModel = $instance::findOrFail($id);
        $instanceModel->update($validatedArray);
        $instanceModel->save();

        return [
            'message' => 'The data has been inserted.',
            'data'    => $instanceModel,
            'code'    => 200,
        ];
    }

    /**
     * @param string $xmlString
     * @param int $modelId
     * @return array
     */
    public function processTag(string $xmlString, int $modelId): array
    {
        $instance = new $this->model();

        if ($instance::where('id', $modelId)->doesntExist()) {
            return response()->xml(
                [
                    'message' => 'The Model with the following id was not found',
                    'data'    => $modelId,
                ], 404);
        }

        $validatedArray = $this->validateXmlSchema($xmlString, $this->tagSchemaPath);

        if (array_key_exists('code', $validatedArray)) {
            return $validatedArray;
        }

        if (TagToAppend::where('id', $validatedArray['id'])->doesntExist()) {
            return response()->xml(
                [
                    'message' => 'The Tag with the following id was not found',
                    'data'    => $validatedArray['id'],
                ], 404);
        }

        /** @var Model|Taggable $instanceModel */
        $instanceModel = $instance::findOrFail($modelId);

        $tag = TagToAppend::findOrFail($validatedArray['id']);

        $instanceModel->tags()->attach([$validatedArray['id']]);

        $instanceModel->save();


        return [
            'message' => 'Tag added.',
            'data'    => $instanceModel,
            'code'    => 200,
        ];
    }

    /**
     * validates the xml string with a schema
     *
     * @param string $xmlString
     * @param string $schemaPath
     * @return array
     */
    protected function validateXmlSchema(string $xmlString, string $schemaPath): array
    {
        $errors = Xml::validate($xmlString, $schemaPath);

        if ($errors) {
            return [
                'message' => 'The data was invalid.',
                'data'    => $errors,
                'code'    => 422,
            ];
        }

        $xml       = simplexml_load_string($xmlString, "SimpleXMLElement", LIBXML_NOCDATA);
        $json      = json_encode($xml);
        $validated = json_decode($json, true);

        foreach ($validated as $key => $value) {
            if ($value == null) {
                return [
                    'message' => 'The data was invalid.',
                    'data'    => 'value for "' . $key . '" is missing',
                    'code'    => 422,
                ];
            }
        }

        return $validated;
    }
}
