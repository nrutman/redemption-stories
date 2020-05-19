<?php
declare(strict_types=1);

namespace Tests\Application\Actions\Story;

use App\Domain\Story\Story;
use App\Domain\Story\StoryRepositoryInterface;
use DI\Container;
use Mockery;
use Tests\TestCase;
use Twig\Environment as TwigEnvironment;

class ViewStoryActionTest extends TestCase
{
    private const RESPONSE_OUTPUT = 'HTML OUTPUT';
    private const VIDEO_BIO_PHOTO = 'photo.jpg';
    private const VIDEO_DESC = '<strong>This is</strong> a description!';
    private const VIDEO_ID = 938;
    private const VIDEO_OWNER_FIRST = 'Jim';
    private const VIDEO_OWNER_LAST = 'Smith';
    private const VIDEO_POSTER_URI = 'http://poster';
    private const VIDEO_SLUG = '293-foobar';
    private const VIDEO_TITLE = 'a title';
    private const VIDEO_TOLD_BY = 'Sally';
    private const VIDEO_URI = 'http://video';

    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $story = new Story(
            self::VIDEO_ID,
            self::VIDEO_SLUG,
            self::VIDEO_BIO_PHOTO,
            self::VIDEO_OWNER_FIRST,
            self::VIDEO_OWNER_LAST,
            self::VIDEO_TITLE,
            self::VIDEO_DESC,
            self::VIDEO_TOLD_BY,
            self::VIDEO_URI,
            self::VIDEO_POSTER_URI
        );

        $storyRepository = Mockery::mock(StoryRepositoryInterface::class);
        $storyRepository
            ->shouldReceive('findBySlug')
            ->with(self::VIDEO_SLUG)
            ->andReturn($story)
            ->once();

        $twig = Mockery::mock(TwigEnvironment::class);
        $twig
            ->shouldReceive('render')
            ->with('story.html.twig', ['story' => $story])
            ->andReturn(self::RESPONSE_OUTPUT)
            ->once();

        $container->set(StoryRepositoryInterface::class, $storyRepository);
        $container->set(TwigEnvironment::class, $twig);

        $request = $this->createRequest('GET', sprintf('story/%s', self::VIDEO_SLUG));
        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(self::RESPONSE_OUTPUT, (string) $response->getBody());
    }
}
