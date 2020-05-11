<?php
declare(strict_types=1);

namespace Tests\Infrastructure\Persistence\Testimony;

use App\Domain\Testimony\Testimony;
use App\Domain\Testimony\TestimonyRepositoryInterface;
use App\Infrastructure\FileSystem\MarkdownFileLoader;
use App\Infrastructure\Persistence\Testimony\TestimonyRepository;
use Mockery;
use Spatie\YamlFrontMatter\Document as YamlDocument;
use Tests\TestCase;

class TestimonyRepositoryTest extends TestCase
{
    private const SLUG_1 = '123-alice';
    private const SLUG_2 = '456-bob';

    /** @var TestimonyRepositoryInterface */
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

        $this->target = new TestimonyRepository(
            $markdownFileLoader
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

    public function testFindBySlug()
    {
        $testimony = $this->target->findBySlug(self::SLUG_2);
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
