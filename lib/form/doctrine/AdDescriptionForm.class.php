<?php

/**
 * AdDescription form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AdDescriptionForm extends BaseAdDescriptionForm
{
  public function configure()
  {
    unset($this['ad_id']);

    if ($this->object->exists())
    {
      $this->widgetSchema['delete'] = new sfWidgetFormInputCheckbox();
      $this->validatorSchema['delete'] = new sfValidatorPass();
    }
  }
}
