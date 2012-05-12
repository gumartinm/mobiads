<?php

/**
 * CompanyCategoryDescription filter form base class.
 *
 * @package    mobiads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCompanyCategoryDescriptionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => true)),
      'company_categ_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyCategory'), 'add_empty' => true)),
      'company_categ_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'company_categ_description' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'language_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Language'), 'column' => 'id')),
      'company_categ_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CompanyCategory'), 'column' => 'id')),
      'company_categ_name'        => new sfValidatorPass(array('required' => false)),
      'company_categ_description' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_category_description_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CompanyCategoryDescription';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'language_id'               => 'ForeignKey',
      'company_categ_id'          => 'ForeignKey',
      'company_categ_name'        => 'Text',
      'company_categ_description' => 'Text',
    );
  }
}
