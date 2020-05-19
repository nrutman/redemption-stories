<?php
declare(strict_types=1);

namespace App\Application\Actions\Story;

use App\Application\Actions\Action;
use App\Domain\Story\StoryNotFoundException;
use App\Domain\Story\StoryRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Twig\Environment as TwigEnvironment;

class ViewStoryAction extends Action
{
    /** @var StoryRepositoryInterface */
    protected $storyRepository;

    /**
     * @param LoggerInterface $logger
     * @param TwigEnvironment $twig
     * @param StoryRepositoryInterface $storyRepository
     */
    public function __construct(LoggerInterface $logger, TwigEnvironment $twig, StoryRepositoryInterface $storyRepository)
    {
        parent::__construct($logger, $twig);
        $this->storyRepository = $storyRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $slug = $this->resolveArg('slug');

        $story = $this
            ->storyRepository
            ->findBySlug($slug);

        if (!$story) {
            throw new StoryNotFoundException();
        }

        return $this->respondWithView('story.html.twig', ['story' => $story]);
    }
}
