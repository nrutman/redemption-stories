<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Testimony;

use App\Domain\Testimony\Testimony;
use App\Domain\Testimony\TestimonyRepository;
use App\Infrastructure\FileSystem\MarkdownFileLoader;
use App\Infrastructure\Persistence\Testimony\InMemoryTestimonyRepository;
use Mockery;
use Spatie\YamlFrontMatter\Document as YamlDocument;
use Tests\TestCase;

class InMemoryTestimonyRepositoryTest extends TestCase
{
    private const SLUG_1 = '123-alice';
    private const SLUG_2 = '456-bob';

    /** @var MarkdownFileLoader|Mockery\LegacyMockInterface|Mockery\MockInterface */
    private $markdownFileLoader;

    /** @var TestimonyRepository */
    private $target;

    public function setUp()
    {
        $this->markdownFileLoader = Mockery::mock(MarkdownFileLoader::class);
        $this
            ->markdownFileLoader
            ->shouldReceive('loadMarkdownFiles')
            ->andReturn([
                self::SLUG_1 => new YamlDocument(['slug' => self::SLUG_1], 'BODY_1'),
                self::SLUG_2 => new YamlDocument(['slug' => self::SLUG_2], 'BODY_2')
            ]);

        $this->target = new InMemoryTestimonyRepository(
            $this->markdownFileLoader
        );
    }

    public function testFindAll()
    {
        /** @var Testimony[] $testimonies */
        $testimonies = $this->target->findAll();
        $this->assertCount(2, $testimonies);
        $this->assertEquals(self::SLUG_1, $testimonies[0]->getSlug());
        $this->assertEquals(self::SLUG_2, $testimonies[1]->getSlug());
    }

    public function testFindTestimonyBySlug()
    {
        $testimony = $this->target->findTestimonyBySlug(self::SLUG_2);
        $this->assertEquals(self::SLUG_2, $testimony->getSlug());
    }

    private static function createTestimony(int $id, string $slug): Testimony
    {
        return new Testimony(
            $id,
            $slug,
            'first',
            'last',
            'description',
            'told by',
            'video uri',
            'poster_uri'
        );
    }
}
