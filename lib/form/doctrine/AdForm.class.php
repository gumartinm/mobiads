<?php

/**
 * Ad form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class AdForm extends BaseAdForm
{
  protected $scheduledForDeletion = array();

  public function configure()
  {
    $this->useFields(array('company_categ_id', 'ad_mobile_image_link'));

    // Ad creation form
    $adDescription = new AdDescription();
    $adDescription->Ad = $this->getObject();
    $newAdDescriptionForm = new AdDescriptionForm($adDescription);

    $this->embedForm('new', $newAdDescriptionForm);

    $this->embedRelation('AdDescription');

  }

  protected function doBind(array $values)
  {
    if ('' === trim($values['new']['ad_description']) && '' === trim($values['new']['ad_mobile_text'])
        && '' === trim($values['new']['ad_name']) && '' === trim($values['new']['ad_link']))
    {
      unset($values['new'], $this['new']);
    }

    if (isset($values['AdDescription']))
    {
      foreach ($values['AdDescription'] as $i => $adDescriptionValues)
      {
        if (isset($adDescriptionValues['delete']) && $adDescriptionValues['id'])
        {
          $this->scheduledForDeletion[$i] = $adDescriptionValues['id'];
        }
      }
    }


    parent::doBind($values);
  }

  /**
   * Updates object with provided values, dealing with evantual relation deletion
   *
   * @see sfFormDoctrine::doUpdateObject()
   */
  protected function doUpdateObject($values)
  {
    if (count($this->scheduledForDeletion))
    {
      foreach ($this->scheduledForDeletion as $index => $id)
      {
        unset($values['AdDescription'][$index]);
        unset($this->object['AdDescription'][$index]);
        Doctrine::getTable('AdDescription')->findOneById($id)->delete();
      }
    }

    $this->getObject()->fromArray($values);
  }

  /**
   * Saves embedded form objects.
   *
   * @param mixed $con   An optional connection object
   * @param array $forms An array of forms
   */
  public function saveEmbeddedForms($con = null, $forms = null)
  {
    if (null === $con)
    {
      $con = $this->getConnection();
    }

    if (null === $forms)
    {
      $forms = $this->embeddedForms;
    }

    foreach ($forms as $form)
    {
      if ($form instanceof sfFormObject)
      {
        if (!in_array($form->getObject()->getId(), $this->scheduledForDeletion))
        {
          $form->saveEmbeddedForms($con);
          $form->getObject()->save($con);
        }
      }
      else
      {
        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
      }
    }
  }
}
