<?php

namespace App\Application\Actions\Testimony;

use App\Application\Actions\Action;
use App\Domain\Testimony\TestimonyRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Twig\Environment as TwigEnvironment;

class ViewTestimonyAction extends Action
{
    /** @var TestimonyRepository */
    protected $testimonyRepository;

    /**
     * @param LoggerInterface $logger
     * @param TwigEnvironment $twig
     * @param TestimonyRepository $testimonyRepository
     */
    public function __construct(LoggerInterface $logger, TwigEnvironment $twig, TestimonyRepository $testimonyRepository)
    {
        parent::__construct($logger, $twig);
        $this->testimonyRepository = $testimonyRepository;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $slug = $this->resolveArg('slug');

        $this
            ->logger
            ->info('Testimony viewed', [
                'slug' => $slug,
            ]);

        return $this->respondWithData(['slug' => $slug]);
    }
}
