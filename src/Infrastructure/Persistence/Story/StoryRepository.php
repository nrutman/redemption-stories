<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Story;

use App\Domain\Story\Story;
use App\Domain\Story\StoryRepositoryInterface;
use App\Infrastructure\FileSystem\MarkdownFileLoader;

class StoryRepository implements StoryRepositoryInterface
{
    /** @var MarkdownFileLoader */
    private $markdownFileLoader;

    /** @var Story[] */
    private $testimonies = [];

    /**
     * @param MarkdownFileLoader $markdownFileLoader
     */
    public function __construct(MarkdownFileLoader $markdownFileLoader)
    {
        $this->markdownFileLoader = $markdownFileLoader;
        $this->testimonies = $this->loadFromMarkdownFiles();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->testimonies);
    }

    /**
     * {@inheritdoc}
     */
    public function findLast(): ?Story
    {
        if (count($this->testimonies) === 0) {
            return null;
        }

        return $this->testimonies[array_key_last($this->testimonies)];
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlug(string $slug): ?Story
    {
        if (!array_key_exists($slug, $this->testimonies)) {
            return null;
        }

        return $this->testimonies[$slug];
    }

    /**
     * @return Story[]
     */
    private function loadFromMarkdownFiles(): array
    {
        $idCounter = 0;
        /** @var Story[] $testimonies */
        $testimonies = [];
        $documents = $this->markdownFileLoader->loadMarkdownFiles(sprintf('%s/../../../../data/story', __DIR__));

        foreach ($documents as $key => $document) {
            $testimonies[$key] = new Story(
                $idCounter++,
                $key,
                $document->matter('bioPhoto'),
                $document->matter('firstName'),
                $document->matter('lastName'),
                $document->matter('title'),
                $document->body(),
                $document->matter('toldBy'),
                $document->matter('video'),
                $document->matter('videoPoster')
            );
        }

        return $testimonies;
    }
}
