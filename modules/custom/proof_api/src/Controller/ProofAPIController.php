<?php

namespace Drupal\proof_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Drupal\proof_api\ProofAPIRequests\ProofAPIRequests;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProofAPIController extends ControllerBase
{
  private $proofAPIRequests;

  public function __construct(ProofAPIRequests $proofAPIRequests)
  {
      $this->proofAPIRequests = $proofAPIRequests;
  }

  /**
   * @return array
   */

  public function allVideos()
  {
    $response = $this->proofAPIRequests->listAllVideos();

    $json = json_decode($response, true);
    $dataArray = $json['data'];
    $createdAt = array();

    foreach ($dataArray as $movie) {
        $createdAt[] = $movie['attributes']['created_at'];
    }

    array_multisort($createdAt, SORT_DESC, $dataArray);

    $page = array(
        '#theme' => 'movies',
        '#movies' => $dataArray,
        '#redirectTo' => 'proof_api.all_videos',
        '#cache' => array
        (
            'max-age' => 0,
        ),
    );

    return $page;

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
    $dataArray = array_slice($dataArray, 0, 10, true);

    $page = array(
        '#theme' => 'movies',
        '#movies' => $dataArray,
        '#redirectTo' => 'proof_api.top_ten_by_views',
        '#cache' => array
        (
            'max-age' => 300,
        ),
    );

    return $page;
  }

  public function topTenByVotes()
  {
    $response = $this->proofAPIRequests->listTopTenByVotes();

    $json = json_decode($response, true);
    $dataArray = $json['data'];
    $voteTally = array();

    foreach ($dataArray as $movie) {
        $voteTally[] = $movie['attributes']['vote_tally'];
    }

    array_multisort($voteTally, SORT_DESC, $dataArray);
    $dataArray = array_slice($dataArray, 0, 10, true);

    $page = array(
        '#theme' => 'movies',
        '#movies' => $dataArray,
        '#redirectTo' => 'proof_api.top_ten_by_votes',
        '#cache' => array
        (
            'max-age' => 300,
        ),
    );

    return $page;
  }

  public function newMovie()
  {
    if (date('N') < 1)
    {
      return $this->redirect('proof_api.new_movie_form');
    } else {
      echo "Sorry - you cannot add new videos on the weekend.";
    }
  }

  public function voteUp($videoID, $redirectTo)
  {
    $this->proofAPIRequests->postNewVoteUp($videoID);

    return $this->redirect($redirectTo);
  }

  public function voteDown($videoID, $redirectTo)
  {
    $this->proofAPIRequests->postNewVoteDown($videoID);

    return $this->redirect($redirectTo);

  }

  public function viewMovie($videoID)
  {

    $response = $this->proofAPIRequests->getVideo($videoID);
    $json = json_decode($response, true);
    $url = $json['data']['attributes']['url'];

    return new TrustedRedirectResponse($url);
  }

  public static function create(ContainerInterface $container)
  {
    $proofAPIRequests = $container->get('proof_api.proof_api_requests');

    return new static($proofAPIRequests);
  }


}