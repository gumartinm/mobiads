<?php

/**
 * Max items per page.
 *
 * Combobox to show the available languages.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class MaxItemsPerPage extends sfFormSymfony
{
  public function setup()
  {
    $this->setWidgets(array('max_items' => new sfWidgetFormInputText(),));

    $this->setValidators(array('max_items' => new sfValidatorNumber(array('required' => true,
                                                                          'trim' => true),
                                                                    array('required' => 'The latitude field is required')),));


    $this->widgetSchema->setNameFormat('max_items_page[%s]');


    $this->widgetSchema->setLabels(array('max_items' => 'Max items per page: ',));


    $this->validatorSchema->setOption('allow_extra_fields', false);
    $this->validatorSchema->setOption('filter_extra_fields', true);

    $this->widgetSchema->setFormFormatterName('table');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    //i18n (Internationalization)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('max_items_form');

    parent::setup();
  }  
}
