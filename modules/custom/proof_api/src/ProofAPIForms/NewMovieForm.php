<?php

namespace Drupal\proof_api\ProofAPIForms;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\proof_api\ProofAPIRequests\ProofAPIRequests;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewMovieForm extends FormBase
{
    private $proofAPIRequests;

    public function __construct(ProofAPIRequests $proofAPIRequests)
    {
        $this->proofAPIRequests = $proofAPIRequests;
    }

    public function getFormId()
    {
        return 'proof_api_new_movie_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['title'] = array(
            '#type' => 'textfield',
            '#title' => t('Movie Title'),
            '#required' => TRUE,
        );

        $form['url'] = array(
            '#type' => 'url',
            '#title' => t('Movie URL'),
            '#required' => TRUE,
            );

        $form['slug'] = array(
            '#type' => 'textfield',
            '#title' => t('Movie Slug: name-in-this-format'),
            '#required' => TRUE,
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
            $form_state->setErrorByName('url', $this->t("The movie url '%url' is invalid.", array('%url' => $form_state->getValue('url'))));
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

       $form_state->setRedirect('proof_api.all_movies');
        return;
    }

    public static function create(ContainerInterface $container)
    {
        $proofAPIRequests = $container->get('proof_api.proof_api_requests');

        return new static($proofAPIRequests);
    }
}
