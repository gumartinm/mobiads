<?php

/**
 * CompanyCategoryDescription form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class CompanyCategoryDescriptionForm extends BaseCompanyCategoryDescriptionForm
{
  public function configure()
  {
    unset($this['company_categ_id']);

    $this->widgetSchema['company_categ_description'] = new sfWidgetFormTextarea();

    if ($this->object->exists())
    {
      $this->widgetSchema['delete'] = new sfWidgetFormInputCheckbox();
      $this->validatorSchema['delete'] = new sfValidatorPass();
    }
  }
}
