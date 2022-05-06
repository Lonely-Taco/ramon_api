<?php

namespace App\Contracts;

interface XmlTagValidatorInterface
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
     * @param string $xmlString
     * @param int $id
     * @return array
     */
    public function processTag(string $xmlString, int $id): array;
}
