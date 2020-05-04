<?php
declare(strict_types=1);

namespace App\Infrastructure\FileSystem;

use Parsedown;
use Spatie\YamlFrontMatter\Document as YamlDocument;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class MarkdownFileLoader
{
    /** @var Parsedown */
    protected $markdownParser;

    /** @var YamlFrontMatter */
    protected $yamlParser;

    /**
     * @param Parsedown $markdownParser
     * @param YamlFrontMatter $yamlParser
     */
    public function __construct(
        Parsedown $markdownParser,
        YamlFrontMatter $yamlParser
    ) {
        $this->markdownParser = $markdownParser;
        $this->yamlParser = $yamlParser;
    }

    /**
     * @param string $pathToFiles
     *
     * @return YamlDocument[]
     */
    public function loadMarkdownFiles(string $pathToFiles): array
    {
        $documents = [];

        $files = glob(sprintf('%s/*.md', realpath($pathToFiles)));

        foreach ($files as $file) {
            $key = basename($file, '.md');
            $doc = $this->yamlParser->parseFile($file);
            $body = $this->markdownParser
                ->setBreaksEnabled(true)
                ->text($doc->body());
            $documents[$key] = new YamlDocument(
                $doc->matter(),
                $body
            );
        }

        return $documents;
    }
}
