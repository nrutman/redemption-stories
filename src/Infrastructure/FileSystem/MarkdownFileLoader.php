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
     * @param string $file
     *
     * @return YamlDocument
     */
    public function loadMarkdownFile(string $file): YamlDocument
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
