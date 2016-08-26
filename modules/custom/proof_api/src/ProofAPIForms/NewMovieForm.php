<?php

namespace Drupal\proof_api\ProofAPIForms;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class NewMovieForm extends FormBase {

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
            '#title' => t('name-in-this-format'),
            '#required' => TRUE,
            );

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Submit'),
        );
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if (!UrlHelper::isValid($form_state->getValue('url'), TRUE)) {
            $form_state->setErrorByName('url', $this->t("The movie url '%url' is invalid.", array('%url' => $form_state->getValue('url'))));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $title = $form_state->getValue('title');
        $url = $form_state->getValue('url');
        $slug = $form_state->getValue('slug');

    }
}
