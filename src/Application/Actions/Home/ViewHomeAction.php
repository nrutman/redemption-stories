<?php
declare(strict_types=1);

namespace App\Application\Actions\Home;

use App\Application\Actions\Action;
use App\Domain\Testimony\TestimonyRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Twig\Environment as TwigEnvironment;

class ViewHomeAction extends Action
{
    /** @var TestimonyRepositoryInterface */
    private $testimonyRepository;

    public function __construct(
        LoggerInterface $logger,
        TwigEnvironment $twig,
        TestimonyRepositoryInterface $testimonyRepository
    ) {
        parent::__construct($logger, $twig);

        $this->testimonyRepository = $testimonyRepository;
    }

    /** {@inheritdoc} */
    protected function action(): Response
    {
        $latest = $this
            ->testimonyRepository
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
