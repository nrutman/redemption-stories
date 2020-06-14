<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Story;

use App\Domain\Story\Story;
use App\Domain\Story\StoryNotFoundException;
use App\Domain\Story\StoryRepositoryInterface;
use App\Infrastructure\FileSystem\FileReader;
use Parsedown;
use Spatie\YamlFrontMatter\Document as YamlDocument;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class StoryRepository implements StoryRepositoryInterface
{
    /** @var FileReader */
    protected $fileReader;

    /** @var Parsedown */
    protected $markdownParser;

    /** @var string */
    private $pathToFiles;

    /** @var Story[]|bool[] */
    private $storyCache = [];

    /** @var YamlFrontMatter */
    protected $yamlParser;

    /**
     * @param FileReader $fileReader
     * @param Parsedown $markdownParser
     * @param YamlFrontMatter $yamlParser
     * @param string $dataPath
     */
    public function __construct(
        FileReader $fileReader,
        Parsedown $markdownParser,
        YamlFrontMatter $yamlParser,
        string $dataPath = '%s/../../../../data/story'
    ) {
        $this->fileReader = $fileReader;
        $this->markdownParser = $markdownParser;
        $this->yamlParser = $yamlParser;
        $this->pathToFiles = realpath(sprintf($dataPath, __DIR__));
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
            $document = $this->loadMarkdownFile(sprintf('%s/%s.md', $this->pathToFiles, $slug));

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

    /**
     * Pre-populates the cache with available files/slugs.
     */
    private function loadFileSlugs()
    {
        $files = $this
            ->fileReader
            ->listFiles(sprintf('%s/*.md', $this->pathToFiles));

        foreach ($files as $file) {
            $this->storyCache[basename($file, '.md')] = false;
        }
    }

    /**
     * Loads a markdown file and returns the structured data.
     *
     * @param $file
     *
     * @return YamlDocument
     */
    private function loadMarkdownFile($file): YamlDocument
    {
        $doc = $this->yamlParser->parseFile($file);
        $body = $this->markdownParser
            ->setBreaksEnabled(true)
            ->text($doc->body());
        return new YamlDocument(
            $doc->matter(),
            $body
        );
    }
}
