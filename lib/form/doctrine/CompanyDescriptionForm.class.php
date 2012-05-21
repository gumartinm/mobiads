<?php

/**
 * CompanyDescription form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class CompanyDescriptionForm extends BaseCompanyDescriptionForm
{
  public function configure()
  {
    unset($this['company_id']);

    $this->widgetSchema->setLabels(array('language_id' => 'Language: '));
    $this->widgetSchema->setLabels(array('company_name' => 'Company Name: '));

    if ($this->object->exists())
    {
      $this->widgetSchema['delete'] = new sfWidgetFormInputCheckbox();
      $this->validatorSchema['delete'] = new sfValidatorPass();
    }

    //i18n (Internationalization)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('company_description_form');
  }
}
