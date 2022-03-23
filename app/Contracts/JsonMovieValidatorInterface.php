<?php

namespace App\Contracts;

interface JsonMovieValidatorInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function processCreate(array $data): array;

    /**
     * @param array $data
     * @param int $id
     * @return array
     */
    public function processEdit(array $data, int $id): array;
}
