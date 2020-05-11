<?php

namespace App\Domain\Testimony;

interface TestimonyRepositoryInterface
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
    public function findBySlug(string $slug): ?Testimony;

    /**
     * @return Testimony|null
     */
    public function findLast(): ?Testimony;
}
