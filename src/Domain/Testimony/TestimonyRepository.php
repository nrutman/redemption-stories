<?php

namespace App\Domain\Testimony;

interface TestimonyRepository
{
    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param string $slug
     *
     * @return Testimony|null
     *
     * @throws TestimonyNotFoundException
     */
    public function findTestimonyBySlug(string $slug): ?Testimony;
}
