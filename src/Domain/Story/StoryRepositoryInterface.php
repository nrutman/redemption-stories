<?php

namespace App\Domain\Story;

interface StoryRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param string $slug
     *
     * @return Story|null
     *
     * @throws StoryNotFoundException
     */
    public function findBySlug(string $slug): ?Story;

    /**
     * @return Story|null
     */
    public function findLast(): ?Story;
}
