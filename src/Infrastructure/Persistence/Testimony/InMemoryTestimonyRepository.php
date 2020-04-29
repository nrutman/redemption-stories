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
        // TODO: Implement findAll() method.
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function findTestimonyBySlug(string $slug): ?Testimony
    {
        // TODO: Implement findTestimonyBySlug() method.
        return null;
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

        foreach ($files as $file) {
            $doc = YamlFrontMatter::parseFile($file);
            $testimonies[] = new Testimony(
                basename($file, '.md'),
                $doc->matter('name') ?? '',
                self::parseMarkdown($doc->body()) ?? '',
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
