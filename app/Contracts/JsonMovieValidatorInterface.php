<?php

namespace App\Contracts;

interface JsonMovieValidatorInterface
{
    /**
     * @param string $data
     * @return array
     */
    public function processCreate(string $data): array;

    /**
     * @param string $data
     * @param int $id
     * @return array
     */
    public function processEdit(string $data, int $id): array;
}
