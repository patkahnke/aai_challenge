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
        $response = $this->proofAPIRequests->listAllMovies();

//        $json = json_decode($response, true);
//        $dataArray = $json['data'];
//        $createdAt = array();
//
//        foreach ($dataArray as $movie) {
//            $createdAt[] = $movie['attributes']['created_at'];
//        }
//
//        array_multisort($createdAt, SORT_DESC, $dataArray);
//
//        print "<table>";
//
//            for ($i = 0; $i < count($dataArray); $i++) {
//
//                print "<tr><td><a href='" . $dataArray[$i]['attributes']['url'] . "'>" . $dataArray[$i]['attributes']['title'] . "</td>";
//            }
//
//            print "</table>";

        return new Response($response);

    }

    public function topTenByViews()
    {
        $response = $this->proofAPIRequests->listTopTenByViews();

        $json = json_decode($response, true);
        $dataArray = $json['data'];
        $viewTally = array();

        foreach ($dataArray as $movie) {
            $viewTally[] = $movie['attributes']['view_tally'];
        }

        array_multisort($viewTally, SORT_DESC, $dataArray);

        print "<table>";

        for ($i = 0; $i < count($dataArray) && $i < 10; $i++) {

            print "<tr><td>" . ($i + 1) . ")</td><td>" . "<a href='./view_movie'>" .
                $dataArray[$i]['attributes']['title'] . "</td><td>" . $dataArray[$i]['attributes']['view_tally'] . " views</td>";
        }

        print "</table>";

        return new Response();
    }

    public function topTenByVotes()
    {
        $response = $this->proofAPIRequests->listTopTenByVotes();

//        $json = json_decode($response, true);
//        $dataArray = $json['data'];
//        $voteTally = array();
//
//        foreach ($dataArray as $movie) {
//            $voteTally[] = $movie['attributes']['vote_tally'];
//        }
//
//        array_multisort($voteTally, SORT_DESC, $dataArray);
//
//        print "<table>";
//
//        for ($i = 0; $i < count($dataArray) && $i < 10; $i++) {
//
//            print "<tr><td>" . ($i + 1) . ")</td><td>" . "<a href='" . $dataArray[$i]['attributes']['url'] . "'>" .
//                $dataArray[$i]['attributes']['title'] . "</td><td>" . $dataArray[$i]['attributes']['vote_tally'] . " votes</td>";
//        }
//
//        print "</table>";

        return new Response($response);
    }

    public function newMovie()
    {
        return $this->redirect('proof_api.new_movie_form');
    }

    public function newVote()
    {
        $this->proofAPIRequests->postNewVote();

        return $this->redirect('proof_api.top_ten_by_votes');
    }

    public function viewMovie()
    {
        $this->proofAPIRequests->postNewView();

        return new Response();
    }

    public static function create(ContainerInterface $container)
    {
        $proofAPIRequests = $container->get('proof_api.proof_api_requests');

        return new static($proofAPIRequests);
    }


}