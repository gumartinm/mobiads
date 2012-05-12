<?php

/**
 * AdDescription filter form base class.
 *
 * @package    mobiads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAdDescriptionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'language_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => true)),
      'ad_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ad'), 'add_empty' => true)),
      'ad_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ad_description' => new sfWidgetFormFilterInput(),
      'ad_mobile_text' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ad_link'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'language_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Language'), 'column' => 'id')),
      'ad_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ad'), 'column' => 'id')),
      'ad_name'        => new sfValidatorPass(array('required' => false)),
      'ad_description' => new sfValidatorPass(array('required' => false)),
      'ad_mobile_text' => new sfValidatorPass(array('required' => false)),
      'ad_link'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ad_description_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdDescription';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'language_id'    => 'ForeignKey',
      'ad_id'          => 'ForeignKey',
      'ad_name'        => 'Text',
      'ad_description' => 'Text',
      'ad_mobile_text' => 'Text',
      'ad_link'        => 'Text',
    );
  }
}
