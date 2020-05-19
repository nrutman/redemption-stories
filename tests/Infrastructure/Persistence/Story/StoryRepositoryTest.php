<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Story;

use App\Domain\Story\Story;
use App\Domain\Story\StoryRepositoryInterface;
use App\Infrastructure\FileSystem\MarkdownFileLoader;
use App\Infrastructure\Persistence\Story\StoryRepository;
use Mockery;
use Spatie\YamlFrontMatter\Document as YamlDocument;
use Tests\TestCase;

class StoryRepositoryTest extends TestCase
{
    private const SLUG_1 = '123-alice';
    private const SLUG_2 = '456-bob';

    /** @var StoryRepositoryInterface */
    private $target;

    public function setUp(): void
    {
        $markdownFileLoader = Mockery::mock(MarkdownFileLoader::class);
        $markdownFileLoader
            ->shouldReceive('loadMarkdownFiles')
            ->andReturn([
                self::SLUG_1 => new YamlDocument(['slug' => self::SLUG_1], 'BODY_1'),
                self::SLUG_2 => new YamlDocument(['slug' => self::SLUG_2], 'BODY_2')
            ]);

        $this->target = new StoryRepository(
            $markdownFileLoader
        );
    }

    public function testFindAll()
    {
        /** @var Story[] $testimonies */
        $testimonies = $this->target->findAll();
        $this->assertCount(2, $testimonies);
        $this->assertEquals(self::SLUG_1, $testimonies[0]->getSlug());
        $this->assertEquals(self::SLUG_2, $testimonies[1]->getSlug());
    }

    public function testFindBySlug()
    {
        $story = $this->target->findBySlug(self::SLUG_2);
        $this->assertEquals(self::SLUG_2, $story->getSlug());
    }

    private static function createStory(int $id, string $slug): Story
    {
        return new Story(
            $id,
            $slug,
            'photo.jpg',
            'first',
            'last',
            'description',
            'told by',
            'video uri',
            'poster_uri'
        );
    }
}
