<?php

namespace App\Contracts;

interface XmlMovieValidatorInterface
{
    /**
     * @param string $xmlString
     * @return array
     */
    public function processCreate(string $xmlString): array;

    /**
     * @param string $xmlString
     * @param int $id
     * @return array
     */
    public function processEdit(string $xmlString, int $id): array;

    /**
     * @param string $tagId
     * @param int $modelId
     * @return array
     */
    public function processTag(string $tagId, int $modelId): array;
}
