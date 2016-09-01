<?php

namespace Drupal\proof_api\ProofAPIForms;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\proof_api\ProofAPIRequests\ProofAPIRequests;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewVideoForm extends FormBase
{
  private $proofAPIRequests;

  public function __construct(ProofAPIRequests $proofAPIRequests)
  {
      $this->proofAPIRequests = $proofAPIRequests;
  }

  public function getFormId()
  {
    return 'proof_api_new_video_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Video Title'),
      '#required' => TRUE,
    );

    $form['url'] = array(
      '#type' => 'url',
      '#title' => t('Video URL'),
      '#required' => TRUE,
      );

    $form['slug'] = array(
      '#type' => 'textfield',
      '#title' => t('Video Slug'),
      '#required' => TRUE,
      '#attributes' => array(
        'placeholder' => t('name-in-this-format'),
      ),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if (!UrlHelper::isValid($form_state->getValue('url'), TRUE)) {
        $form_state->setErrorByName('url', t("The movie url '%url' is invalid.", array('%url' => $form_state->getValue('url'))));
    }
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $title = $form_state->getValue('title');
    $url = $form_state->getValue('url');
    $slug = $form_state->getValue('slug');

    $this->proofAPIRequests->postNewMovie($title, $url, $slug);

    $form_state->setRedirect('proof_api.all_videos');
    return;
  }

  public static function create(ContainerInterface $container)
  {
    $proofAPIRequests = $container->get('proof_api.proof_api_requests');

    return new static($proofAPIRequests);
  }
}
