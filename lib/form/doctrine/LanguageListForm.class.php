<?php

/**
 * Language list select form.
 *
 * Combobox to show the available languages.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class LanguageListForm extends BaseLanguageForm
{
  public function configure()
  {
    $this->useFields(array('id'));

    $this->widgetSchema['id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getModelName(),
                                                                                'add_empty' => false,
                                                                                'multiple' => false));

    $this->validatorSchema['id'] = new sfValidatorDoctrineChoice(array('model' => $this->getModelName(),
                                                                                  'required' => true,
                                                                                  'multiple' => false));

    $this->widgetSchema->setLabels(array('id' => 'Language: ',));

    //i18n (Internationalization)
    //See apps/companyfront/modules/language/i18n/language_select_form.es.xml file (not created yet)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('language_select_form');


    //Every form must have its own name
    $this->widgetSchema->setNameFormat('languageselect[%s]');
  }
}
