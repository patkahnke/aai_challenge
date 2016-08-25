<?php

namespace Drupal\proof_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\proof_api\ProofAPIRequests\GetAllMovies;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class ProofAPIController extends ControllerBase
{
    private $getAllMovies;

    public function __construct(GetAllMovies $getAllMovies)
{
    $this->getAllMovies = $getAllMovies;
}

    public function allMovies()
{
    $allMovies = $this->getAllMovies->listAllMovies();

    return new Response($allMovies);
}

    public function topTen()
    {
        $topTenByViews = $this->getAllMovies->listTopTenByViews();

        return new Response($topTenByViews);
    }

    public static function create(ContainerInterface $container)
{
    $getAllMovies = $container->get('proof_api.get_all_movies');

    return new static($getAllMovies);
}
}