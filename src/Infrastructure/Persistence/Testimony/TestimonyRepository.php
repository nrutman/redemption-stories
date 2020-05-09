<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Testimony;

use App\Domain\Testimony\Testimony;
use App\Domain\Testimony\TestimonyRepositoryInterface;
use App\Infrastructure\FileSystem\MarkdownFileLoader;

class TestimonyRepository implements TestimonyRepositoryInterface
{
    /** @var MarkdownFileLoader */
    private $markdownFileLoader;

    /** @var Testimony[] */
    private $testimonies = [];

    /**
     * @param MarkdownFileLoader $markdownFileLoader
     * @param Testimony[]|null $testimonies
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
    public function findTestimonyBySlug(string $slug): ?Testimony
    {
        if (!array_key_exists($slug, $this->testimonies)) {
            return null;
        }

        return $this->testimonies[$slug];
    }

    /**
     * @return Testimony[]
     */
    private function loadFromMarkdownFiles(): array
    {
        $idCounter = 0;
        /** @var Testimony[] $testimonies */
        $testimonies = [];
        $documents = $this->markdownFileLoader->loadMarkdownFiles(sprintf('%s/../../../../data/testimony', __DIR__));

        foreach ($documents as $key => $document) {
            $testimonies[$key] = new Testimony(
                $idCounter++,
                $key,
                $document->matter('firstName') ?? '',
                $document->matter('lastName') ?? '',
                $document->body() ?? '',
                $document->matter('toldBy') ?? '',
                $document->matter('video') ?? '',
                $document->matter('videoPoster') ?? ''
            );
        }

        return $testimonies;
    }
}
