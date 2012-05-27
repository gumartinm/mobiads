<?php

/**
 * UsersRegisterForm for registering new users
 *
 * @package    mobileadvertising
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class UsersRegisterForm extends BasesfGuardRegisterForm
{
  /**
   * @see sfForm
   */
  public function configure()
  { 
    $this->widgetSchema['language_id'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getRelatedModelName('Language'),
                                                                              'add_empty' => false));

    $this->validatorSchema['language_id'] = new sfValidatorDoctrineChoice(array('model'    => $this->getRelatedModelName('Language'),
                                                                                'required' => true));

    $this->widgetSchema['captcha'] = new sfWidgetFormReCaptcha(array('public_key' => sfConfig::get('app_recaptcha_public_key')));

    $this->validatorSchema['captcha'] = new sfValidatorReCaptcha(array('private_key' => sfConfig::get('app_recaptcha_private_key')));
  }   
} 
