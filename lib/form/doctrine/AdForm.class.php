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

    //Narrow down the valid options for some field validators
    $companyCategs = CompanyCategoryTable::getInstance()->getCompanyCategoriesByCompanyIdQuery($this->getOption('company_user_id'));

    //The default value is not good enough for us. We need narrow down the results.
    $this->widgetSchema['company_categ_id'] = new sfWidgetFormDoctrineChoice(array('model'    => $this->getModelName(),
                                                                                  'add_empty' => true,
                                                                                  'query'     => $companyCategs));

    $this->validatorSchema['company_categ_id'] = new sfValidatorDoctrineChoice(array('model'   => $this->getModelName(),
                                                                                    'required' => false,
                                                                                    'query'    => $companyCategs));


    $this->widgetSchema['ad_mobile_image_link'] =
                new sfWidgetFormInputFileEditable(array('file_src'    => '/uploads/images/'.$this->getObject()->ad_mobile_image_link,
                                                        'edit_mode'   => !$this->isNew(),
                                                        'is_image'    => true,
                                                        'with_delete' => false));


    $this->validatorSchema['ad_mobile_image_link'] = new sfValidatorFile(array('mime_types' => 'web_images',
                                                                               'path' => sfConfig::get('app_default_picture_directory'),
                                                                               'required' => true));


    $this->widgetSchema->setLabels(array('company_categ_id'  => 'Company Category'));
    $this->widgetSchema->setLabels(array('ad_mobile_image_link' => "Picture on the user's mobile"));


    //i18n (Internationalization)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('ad_form');

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
