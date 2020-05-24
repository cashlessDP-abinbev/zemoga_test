<?php

/**
 * @file
 * Contains \Drupal\zemoga_haspe\Form\ZemogaHasp3.
 */

namespace Drupal\zemoga_haspe\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;

class ZemogaHasp3 extends ZemogaHaspe {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'zemoga_form_three';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $dateb = $this->store->get('date_birth');

    $user = user_load_by_mail($this->store->get('phone')."@".$this->store->get('phone').".com");
 	$ru = is_object($user);

  	if(!$ru){

  		$language = \Drupal::languageManager()->getCurrentLanguage()->getId();
		$user = \Drupal\user\Entity\User::create();

		// Mandatory.
		$user->setPassword($this->store->get('phone'));
		$user->enforceIsNew();
		$user->setEmail($this->store->get('phone')."@".$this->store->get('phone').".com");
		$user->setUsername($this->store->get('phone')."@".$this->store->get('phone').".com");

		// Optional.
		$user->set('init', $this->store->get('phone')."@".$this->store->get('phone').".com");
		$user->set('langcode', $language);
		$user->set('preferred_langcode', $language);
		$user->set('preferred_admin_langcode', $language);
		$user->activate();

		// Save user account.
		$result = $user->save();

  		$form['test'] = array(
		    '#type' => 'markup',
		    '#markup' => 
		    	'<div>
		    		<p><h2>'.$this->t('Your user was create with these information').'</h2><p>
		    		<p><strong>'.$this->t('First name').'</strong>: '.$this->store->get('first_name').'</p>
		    		<p><strong>'.$this->t('Last name').'</strong>: '.$this->store->get('last_name').'</p>
		    		<p><strong>'.$this->t('Gender').'</strong>: '.$this->store->get('gender_select').'</p>
		    		<p><strong>'.$this->t('City').'</strong>: '.$this->store->get('city').'</p>
		    		<p><strong>'.$this->t('Phone').'</strong>: '.$this->store->get('phone').'</p>
		    		<p><strong>'.$this->t('Address').'</strong>: '.$this->store->get('address').'</p>
		    		<p><strong>'.$this->t('Date Birth').'</strong>: '.$dateb.'</p>
		    	</div>',
		  );
  		\Drupal::messenger()->addStatus(t('Thanks for you registration!'));
  	}else{
  		
  		$form['test'] = array(
	    '#type' => 'markup',
	    '#markup' => 
	    	'<div>
	    		<p><h2>'.$this->t('User already exists with this mail').'</h2><p>
	    		<p>'.$this->store->get('phone')."@".$this->store->get('phone').".com".'</p>
	    	</div>',
	  	);
  		\Drupal::messenger()->addStatus(t('User already exists with this mail!'));
  	}

  	$form['actions']['submit'] = array(
      '#type' => 'button',
      '#value' => $this->t('Finish!'),
      '#ajax' => array(
        'callback' => '::setInfor3',
      ),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

  public function setInfor3(array &$form, FormStateInterface $form_state) {

  	$this->store->delete('first_name');
  	$this->store->delete('last_name');
  	$this->store->delete('gender_select');
  	$this->store->delete('city');
  	$this->store->delete('address');
  	$this->store->delete('phone');
  	$this->store->delete('date_birth');

    $response = new AjaxResponse();
    $response->addCommand(new RedirectCommand('step1'));
    return $response;
  }
}