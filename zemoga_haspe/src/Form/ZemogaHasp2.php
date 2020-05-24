<?php

/**
 * @file
 * Contains \Drupal\zemoga_haspe\Form\ZemogaHasp2.
 */

namespace Drupal\zemoga_haspe\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;

class ZemogaHasp2 extends ZemogaHaspe {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'zemoga_form_two';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $form['city'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your city'),
      '#default_value' => $this->store->get('city') ? $this->store->get('city') : '',
      '#required' => TRUE,
    );

    $form['phone'] = array(
      '#type' => 'number',
      '#title' => $this->t('Phone Number'),
      '#default_value' => $this->store->get('phone') ? $this->store->get('phone') : '',
    );

    $form['address'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Address'),
      '#default_value' => $this->store->get('address') ? $this->store->get('address') : '',
    );

    $form['actions']['previous'] = array(
      '#type' => 'link',
      '#title' => $this->t('Previous'),
      '#attributes' => array(
        'class' => array('button'),
      ),
      '#weight' => 0,
      '#url' => Url::fromRoute('zemoga_haspe.zemogahasp1'),
    );

    $form['actions']['submit'] = array(
      '#type' => 'button',
      '#value' => $this->t('Next step!'),
      '#ajax' => array(
        'callback' => '::setInfor2',
      ),
    );


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }


  public function setInfor2(array &$form, FormStateInterface $form_state) {

    $this->store->set('city', $form_state->getValue('city'));
    $this->store->set('phone', $form_state->getValue('phone'));
    $this->store->set('address', $form_state->getValue('address'));

    $response = new AjaxResponse();
    $response->addCommand(new RedirectCommand('step3'));
    return $response;

  }

}