<?php

/**
 * Country filter form base class.
 *
 * @package    mobiads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCountryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'country_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'iso_code_2'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'iso_code_3'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'country_name' => new sfValidatorPass(array('required' => false)),
      'iso_code_2'   => new sfValidatorPass(array('required' => false)),
      'iso_code_3'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('country_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Country';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'country_name' => 'Text',
      'iso_code_2'   => 'Text',
      'iso_code_3'   => 'Text',
    );
  }
}
