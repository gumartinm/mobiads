<?php

/**
 * Ad form base class.
 *
 * @method Ad getObject() Returns the current form's model object
 *
 * @package    mobiads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAdForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'company_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => false)),
      'company_categ_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyCategory'), 'add_empty' => true)),
      'ad_gps'               => new sfWidgetFormTextarea(),
      'ad_mobile_image_link' => new sfWidgetFormTextarea(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'))),
      'company_categ_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyCategory'), 'required' => false)),
      'ad_gps'               => new sfValidatorString(array('required' => false)),
      'ad_mobile_image_link' => new sfValidatorString(array('max_length' => 3000)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('ad[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ad';
  }

}
