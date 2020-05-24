<?php

/**
 * @file
 * Contains \Drupal\zemoga_haspe\Form\ZemogaHasp1.
 */

namespace Drupal\zemoga_haspe\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Url;

class ZemogaHasp1 extends ZemogaHaspe {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'zemoga_form_one';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your first name'),
      '#default_value' => $this->store->get('first_name') ? $this->store->get('first_name') : '',
      '#required' => TRUE,
    );

    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your last name'),
      '#default_value' => $this->store->get('last_name') ? $this->store->get('last_name') : '',
      '#required' => TRUE,
    );

    $form['gender_select'] = array(
      '#type' => 'select',
      '#title' => $this->t('Select Gender'),
      '#options' => array(
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ),
    );

    $form['date_birth'] = array(
          '#type' => 'date',
          '#title' => $this->t('Enter Your Date of Birth'),
          '#required' => TRUE,
          '#default_value' => array('month' => 1, 'day' => 1, 'year' => 1991),
          '#format' => 'm/d/Y',
          '#description' => t('i.e. 09/06/2016'),
      );

    $form['actions']['submit'] = array(
      '#type' => 'button',
      '#value' => $this->t('Next step!'),
      '#ajax' => array(
        'callback' => '::setInfor',
      ),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }

  /**
   *
   */
  public function setInfor(array &$form, FormStateInterface $form_state) {

    $this->store->set('first_name', $form_state->getValue('first_name'));
    $this->store->set('last_name', $form_state->getValue('last_name'));
    $this->store->set('gender_select', $form_state->getValue('gender_select'));
    $this->store->set('date_birth', $form_state->getValue('date_birth'));
    

    $response = new AjaxResponse();
    $response->addCommand(new RedirectCommand('step2'));
    return $response;

  }

}