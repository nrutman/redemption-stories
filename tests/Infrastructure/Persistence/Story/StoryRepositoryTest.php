<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Story;

use App\Domain\Story\Story;
use App\Domain\Story\StoryRepositoryInterface;
use App\Infrastructure\FileSystem\FileReader;
use App\Infrastructure\Persistence\Story\StoryRepository;
use Mockery;
use Parsedown;
use Spatie\YamlFrontMatter\Document as YamlDocument;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Tests\TestCase;

class StoryRepositoryTest extends TestCase
{
    private const FILE_PATH = 'PATH';
    private const SLUG_1 = '123-alice';
    private const SLUG_2 = '456-bob';

    protected $fileReader;

    protected $yamlParser;

    /** @var StoryRepositoryInterface */
    private $target;

    public function setUp(): void
    {
        $this->fileReader = Mockery::mock(FileReader::class);
        $this->yamlParser = Mockery::mock(YamlFrontMatter::class);

        $this
            ->fileReader
            ->shouldReceive('listFiles')
            ->andReturn([
                sprintf('%s.md', self::SLUG_1),
                sprintf('%s.md', self::SLUG_2),
            ])
            ->byDefault();

        $this
            ->yamlParser
            ->shouldReceive('parseFile')
            ->andReturn(new YamlDocument([], 'TEXT'))
            ->byDefault();

        $this->target = new StoryRepository(
            $this->fileReader,
            (new Parsedown()),
            $this->yamlParser,
            self::FILE_PATH
        );
    }

    public function testFindAll(): void
    {
        /** @var Story[] $stories */
        $stories = $this->target->findAll();

        $this->assertCount(2, $stories);
        $this->assertEquals(self::SLUG_1, $stories[0]->getSlug());
        $this->assertEquals(self::SLUG_2, $stories[1]->getSlug());
    }

    public function test_findLast(): void
    {
        $result = $this->target->findLast();

        $this->assertEquals(self::SLUG_2, $result->getSlug());
    }

    public function testFindBySlug(): void
    {
        $story1 = $this->target->findBySlug(self::SLUG_1);
        $story2 = $this->target->findBySlug(self::SLUG_2);

        $this->assertEquals(self::SLUG_1, $story1->getSlug());
        $this->assertEquals(self::SLUG_2, $story2->getSlug());
    }
}
