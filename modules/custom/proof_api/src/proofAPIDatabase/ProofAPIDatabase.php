<?php

/**
 * Created by PhpStorm.
 * User: patrickkahnke
 * Date: 9/4/16
 * Time: 2:26 PM
 */

use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProofAPIDatabase {

  private $proofAPIDatabase;

  public function __construct(Connection $proofAPIDatabase) {
    $this->proofAPIDatabase = $proofAPIDatabase;
  }

  public function getVotesDB() {
//    $userID = \Drupal::currentUser()->id();

    $results = $this->proofAPIDatabase->query('SELECT * FROM {votesTable}');//

    return $results;
  }

  public static function create(ContainerInterface $container) {
    $proofAPIDatabase = $container->get('proof_api.proof_api_database');

    return new static($proofAPIDatabase);
  }
}