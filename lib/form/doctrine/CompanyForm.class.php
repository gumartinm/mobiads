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


    $this->widgetSchema->setLabels(array('company_cif' => 'CIF: '));


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
