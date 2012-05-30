<?php

/**
 * Company form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class CompanyForm extends BaseCompanyForm
{
  /*Stores Doctrine Records to be removed from the database.*/
  protected $scheduledForDeletion = array();

  public function configure()
  {
    $this->useFields(array('company_cif'));


    $this->widgetSchema['company_logo'] =
                new sfWidgetFormInputFileEditable(array('file_src'    => '/uploads/images/'.$this->getObject()->company_logo,
                                                        'edit_mode'   => !$this->isNew(),
                                                        'is_image'    => true,
                                                        'with_delete' => false));


    $this->validatorSchema['company_logo'] = new sfValidatorFileImage(array('mime_types' => 'web_images',
                                                                            'path' => sfConfig::get('app_default_picture_directory'),
                                                                            'required' => $this->isNew(),
                                                                            'is_only_image' => true,
                                                                            'max_height' => 150,
                                                                            'min_height' => 128,
                                                                            'max_width' => 150,
                                                                            'min_width' => 128,
                                  'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif','application/x-shockwave-flash')));



    $this->widgetSchema->setLabels(array('company_cif' => 'CIF: '));
    $this->widgetSchema->setLabels(array('company_logo' => "Your company logo: "));


    //Company create new description form
    $companyDescription = new CompanyDescription();
    $companyDescription->Company = $this->getObject();
    $newCompanyDescriptionForm = new CompanyDescriptionForm($companyDescription);

    $this->embedForm('new', $newCompanyDescriptionForm);

    $this->embedRelation('CompanyDescription');


    //i18n (Internationalization)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('company_form');
  }

  protected function doBind(array $values)
  {
    if ('' === trim($values['new']['company_name']))
    {
      unset($values['new'], $this['new']);
    }

    if (isset($values['CompanyDescription']))
    {
      foreach ($values['CompanyDescription'] as $i => $companyDescriptionValues)
      {
        if (isset($companyDescriptionValues['delete']) && $companyDescriptionValues['id'])
        {
          $this->scheduledForDeletion[$i] = $companyDescriptionValues['id'];
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
        unset($values['CompanyDescription'][$index]);
        unset($this->object['CompanyDescription'][$index]);
        Doctrine::getTable('CompanyDescription')->findOneById($id)->delete();
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
