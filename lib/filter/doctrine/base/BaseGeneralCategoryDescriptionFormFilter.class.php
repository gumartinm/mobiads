<?php

/**
 * GeneralCategoryDescription filter form base class.
 *
 * @package    mobiads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGeneralCategoryDescriptionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => true)),
      'general_categ_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GeneralCategory'), 'add_empty' => true)),
      'general_categ_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'general_categ_description' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'language_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Language'), 'column' => 'id')),
      'general_categ_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('GeneralCategory'), 'column' => 'id')),
      'general_categ_name'        => new sfValidatorPass(array('required' => false)),
      'general_categ_description' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('general_category_description_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'GeneralCategoryDescription';
  }

  public function getFields()
  {
    return array(
      'id'                        => 'Number',
      'language_id'               => 'ForeignKey',
      'general_categ_id'          => 'ForeignKey',
      'general_categ_name'        => 'Text',
      'general_categ_description' => 'Text',
    );
  }
}
