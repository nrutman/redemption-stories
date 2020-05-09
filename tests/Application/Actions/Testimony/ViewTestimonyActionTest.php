<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Testimony;

use App\Domain\Testimony\Testimony;
use App\Domain\Testimony\TestimonyRepository;
use DI\Container;
use Mockery;
use Tests\TestCase;
use Twig\Environment as TwigEnvironment;

class ViewTestimonyActionTest extends TestCase
{
    private const RESPONSE_OUTPUT = 'HTML OUTPUT';
    private const VIDEO_DESC = '<strong>This is</strong> a description!';
    private const VIDEO_ID = 938;
    private const VIDEO_OWNER_FIRST = 'Jim';
    private const VIDEO_OWNER_LAST = 'Smith';
    private const VIDEO_POSTER_URI = 'http://poster';
    private const VIDEO_SLUG = '293-foobar';
    private const VIDEO_TOLD_BY = 'Sally';
    private const VIDEO_URI = 'http://video';

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $testimony = new Testimony(
            self::VIDEO_ID,
            self::VIDEO_SLUG,
            self::VIDEO_OWNER_FIRST,
            self::VIDEO_OWNER_LAST,
            self::VIDEO_DESC,
            self::VIDEO_TOLD_BY,
            self::VIDEO_URI,
            self::VIDEO_POSTER_URI
        );

        $testimonyRepository = Mockery::mock(TestimonyRepository::class);
        $testimonyRepository
            ->shouldReceive('findTestimonyBySlug')
            ->with(self::VIDEO_SLUG)
            ->andReturn($testimony)
            ->once();

        $twig = Mockery::mock(TwigEnvironment::class);
        $twig
            ->shouldReceive('render')
            ->with('testimony.html.twig', ['story' => $testimony])
            ->andReturn(self::RESPONSE_OUTPUT)
            ->once();

        $container->set(TestimonyRepository::class, $testimonyRepository);
        $container->set(TwigEnvironment::class, $twig);

        $request = $this->createRequest('GET', sprintf('story/%s', self::VIDEO_SLUG));
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(self::RESPONSE_OUTPUT, (string) $response->getBody());
    }
}
