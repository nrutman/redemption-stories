<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Story;

use App\Domain\Story\Story;
use App\Domain\Story\StoryNotFoundException;
use App\Domain\Story\StoryRepositoryInterface;
use App\Infrastructure\FileSystem\MarkdownFileLoader;

class StoryRepository implements StoryRepositoryInterface
{
    /** @var MarkdownFileLoader */
    private $markdownFileLoader;

    /** @var string */
    private $pathToFiles;

    /** @var Story[]|bool[] */
    private $storyCache = [];

    /**
     * @param MarkdownFileLoader $markdownFileLoader
     * @param string $dataPath
     */
    public function __construct(MarkdownFileLoader $markdownFileLoader, string $dataPath = '%s/../../../../data/story')
    {
        $this->markdownFileLoader = $markdownFileLoader;
        $this->pathToFiles = sprintf($dataPath, __DIR__);
        $this->loadFileSlugs();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        // make sure entire cache is populated
        foreach ($this->storyCache as $slug => $story) {
            if ($story === false) {
                $this->fetchStory($slug);
            }
        }

        return array_values($this->storyCache);
    }

    /**
     * {@inheritdoc}
     */
    public function findLast(): ?Story
    {
        if (count($this->storyCache) === 0) {
            return null;
        }

        return $this->fetchStory(array_key_last($this->storyCache));
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlug(string $slug): ?Story
    {
        if (!array_key_exists($slug, $this->storyCache)) {
            return null;
        }

        return $this->fetchStory($slug);
    }

    /**
     * Pre-populates the cache with available files/slugs.
     */
    private function loadFileSlugs()
    {
        $pathToFiles = sprintf('%s/../../../../data/story', __DIR__);

        $files = glob(sprintf('%s/*.md', realpath($pathToFiles)));

        foreach ($files as $file) {
            $this->storyCache[basename($file, '.md')] = false;
        }
    }

    /**
     * Fetches a story either from the cache or by reading the markdown file.
     *
     * @param string $slug
     *
     * @return Story|null
     */
    private function fetchStory(string $slug): ?Story
    {
        if (!array_key_exists($slug, $this->storyCache)) {
            return null;
        }

        if ($this->storyCache[$slug] === false) {
            // load the story
            $document = $this->markdownFileLoader->loadMarkdownFile(sprintf('%s/%s.md', $this->pathToFiles, $slug));

            $this->storyCache[$slug] = new Story(
                intval($slug),
                $slug,
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

        return $this->storyCache[$slug];
    }
}
