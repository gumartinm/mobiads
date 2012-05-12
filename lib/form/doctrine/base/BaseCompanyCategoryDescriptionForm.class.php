<?php

/**
 * CompanyCategoryDescription form base class.
 *
 * @method CompanyCategoryDescription getObject() Returns the current form's model object
 *
 * @package    mobiads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyCategoryDescriptionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'language_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => false)),
      'company_categ_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyCategory'), 'add_empty' => false)),
      'company_categ_name'        => new sfWidgetFormInputText(),
      'company_categ_description' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'language_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Language'))),
      'company_categ_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyCategory'))),
      'company_categ_name'        => new sfValidatorString(array('max_length' => 255)),
      'company_categ_description' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_category_description[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyCategoryDescription';
  }

}
