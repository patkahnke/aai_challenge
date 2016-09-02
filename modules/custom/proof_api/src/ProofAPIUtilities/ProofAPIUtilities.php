<?php
/**
 * Created by PhpStorm.
 * User: patrickkahnke
 * Date: 9/2/16
 * Time: 12:55 AM
 */

namespace Drupal\proof_api\ProofAPIUtilities;

class ProofAPIUtilities {

  private $proofAPIRequests;

  public function __construct(ProofAPIRequests $proofAPIRequests)
  {
    $this->proofAPIRequests = $proofAPIRequests;
  }

  public function urlsMatch($url1, $url2) {
    $url1 = preg_replace('#^https?://#', '', $url1);
    $url2 = preg_replace('#^https?://#', '', $url2);
    if ($url1 === $url2) {
      return true;
    }
    else {
      return false;
    };
  }

  public function slugsMatch($slug1, $slug2) {
    if ($slug1 === $slug2) {
      return true;
    } else {
      return false;
    };
  }

  public function videosMatch($newUrl, $newSlug, $proofAPIRequests) {
    $response = $this->$proofAPIRequests->listAllMovies();

  }

  public static function create(ContainerInterface $container)
  {
    $proofAPIRequests = $container->get('proof_api.proof_api_requests');

    return new static($proofAPIRequests);
  }

}