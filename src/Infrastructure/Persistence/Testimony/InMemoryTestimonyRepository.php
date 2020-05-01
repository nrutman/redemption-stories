<?php

namespace App\Infrastructure\Persistence\Testimony;

use App\Domain\Testimony\Testimony;
use App\Domain\Testimony\TestimonyRepository;
use Parsedown;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class InMemoryTestimonyRepository implements TestimonyRepository
{

    /** @var Testimony[] */
    private $testimonies = [];

    public function __construct()
    {
        $this->testimonies = self::loadTestimonies(sprintf('%s/../../../../data/testimony', __DIR__));
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
     * @param $path
     *
     * @return Testimony[]
     */
    private static function loadTestimonies($path): array
    {
        /** @var Testimony[] $testimonies */
        $testimonies = [];

        $files = glob(sprintf('%s/*.md', realpath($path)));

        foreach ($files as $i => $file) {
            $doc = YamlFrontMatter::parseFile($file);
            $key = basename($file, '.md');
            $testimonies[$key] = new Testimony(
                $i,
                $key,
                $doc->matter('firstName') ?? '',
                $doc->matter('lastName') ?? '',
                self::parseMarkdown($doc->body()) ?? '',
                $doc->matter('toldBy') ?? '',
                $doc->matter('video') ?? '',
                $doc->matter('videoPoster') ?? ''
            );
        }

        return $testimonies;
    }

    /**
     * Parses markdown and returns the HTML.
     *
     * @param string $markdown
     *
     * @return string
     */
    private static function parseMarkdown(string $markdown): string
    {
        return Parsedown::instance()
            ->setBreaksEnabled(true)
            ->text($markdown);
    }
}
