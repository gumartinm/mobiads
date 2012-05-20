<?php

/**
 * AdDescription form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
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
