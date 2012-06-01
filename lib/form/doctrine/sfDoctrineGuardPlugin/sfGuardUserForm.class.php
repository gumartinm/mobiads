<?php

/**
 * sfGuardUser form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $this->useFields(array('first_name', 'last_name', 'email_address', 'language_id'));


    $this->widgetSchema['language_id'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getRelatedModelName('Language'),
                                                                              'add_empty' => false));


    $this->validatorSchema['language_id'] = new sfValidatorDoctrineChoice(array('model'    => $this->getRelatedModelName('Language'),
                                                                                'required' => true));

  }
}
