<?php

/**
 * OfficeAds filter form base class.
 *
 * @package    mobiads
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOfficeAdsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'office_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Office'), 'add_empty' => true)),
      'ad_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ad'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'office_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Office'), 'column' => 'id')),
      'ad_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ad'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('office_ads_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OfficeAds';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'office_id' => 'ForeignKey',
      'ad_id'     => 'ForeignKey',
    );
  }
}
