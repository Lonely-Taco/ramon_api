<?php

namespace App\Contracts;

interface XmlBookValidatorInterface
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
}
