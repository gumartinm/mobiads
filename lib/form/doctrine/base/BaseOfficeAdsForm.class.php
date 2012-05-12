<?php

/**
 * OfficeAds form base class.
 *
 * @method OfficeAds getObject() Returns the current form's model object
 *
 * @package    mobiads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOfficeAdsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'office_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Office'), 'add_empty' => false)),
      'ad_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ad'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'office_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Office'))),
      'ad_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ad'))),
    ));

    $this->widgetSchema->setNameFormat('office_ads[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OfficeAds';
  }

}
