<?php
declare(strict_types=1);

namespace App\Application\Actions\Home;

use App\Application\Actions\Action;
use App\Domain\Story\StoryRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Twig\Environment as TwigEnvironment;

class ViewHomeAction extends Action
{
    /** @var StoryRepositoryInterface */
    private $storyRepository;

    public function __construct(
        LoggerInterface $logger,
        TwigEnvironment $twig,
        StoryRepositoryInterface $storyRepository
    ) {
        parent::__construct($logger, $twig);

        $this->storyRepository = $storyRepository;
    }

    /** {@inheritdoc} */
    protected function action(): Response
    {
        $latest = $this
            ->storyRepository
            ->findLast();

        return $this
            ->response
            ->withStatus(302)
            ->withHeader('Location', sprintf('/story/%s', $latest->getSlug()));
        /*
         * return $this->respondWithView('home.html.twig');
         */
    }
}
