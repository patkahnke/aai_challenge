<?php

namespace Drupal\proof_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\proof_api\ProofAPIRequests\ProofAPIRequests;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class ProofAPIController extends ControllerBase
{
    private $proofAPIRequests;

    public function __construct(ProofAPIRequests $proofAPIRequests)
    {
        $this->proofAPIRequests = $proofAPIRequests;
    }

    public function allMovies()
    {
        $this->proofAPIRequests->listAllMovies();

        return new Response();
    }

    public function topTenByViews()
    {
        $this->proofAPIRequests->listTopTenByViews();

        return new Response();
    }

    public function topTenByVotes()
    {
        $this->proofAPIRequests->listTopTenByVotes();

        return new Response();
    }

    public function newMovie()
    {
        $this->proofAPIRequests->postNewMovie();
        $this->proofAPIRequests->listAllMovies();

        return new Response();
    }

        public static function create(ContainerInterface $container)
    {
        $proofAPIRequests = $container->get('proof_api.proof_api_requests');

        return new static($proofAPIRequests);
    }
}