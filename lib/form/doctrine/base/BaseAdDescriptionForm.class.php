<?php

/**
 * AdDescription form base class.
 *
 * @method AdDescription getObject() Returns the current form's model object
 *
 * @package    mobiads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAdDescriptionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'language_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Language'), 'add_empty' => false)),
      'ad_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ad'), 'add_empty' => false)),
      'ad_name'        => new sfWidgetFormInputText(),
      'ad_description' => new sfWidgetFormInputText(),
      'ad_mobile_text' => new sfWidgetFormTextarea(),
      'ad_link'        => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'language_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Language'))),
      'ad_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ad'))),
      'ad_name'        => new sfValidatorString(array('max_length' => 255)),
      'ad_description' => new sfValidatorPass(array('required' => false)),
      'ad_mobile_text' => new sfValidatorString(array('max_length' => 500)),
      'ad_link'        => new sfValidatorString(array('max_length' => 3000)),
    ));

    $this->widgetSchema->setNameFormat('ad_description[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AdDescription';
  }

}
