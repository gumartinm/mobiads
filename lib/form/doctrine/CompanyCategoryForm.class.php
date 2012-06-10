<?php

/**
 * CompanyCategory form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class CompanyCategoryForm extends BaseCompanyCategoryForm
{
  /*Stores Doctrine Records to be removed from the database.*/
  protected $scheduledForDeletion = array();


  public function configure()
  {
    $this->useFields(array('general_categ_id'));

    //Narrow down the valid options for some field validators
    $companyCategs = CompanyCategoryTable::getInstance()->getCompanyCategoriesByCompanyIdQuery($this->getOption('company_user_id'),
                                                                                               $this->getOption('current_category'));

    $this->widgetSchema['parent_category'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getModelName(),
                                                                                  'add_empty' => false,
                                                                                  'query'     => $companyCategs));

    $this->validatorSchema['parent_category'] = new sfValidatorDoctrineChoice(array('model'    => $this->getModelName(),
                                                                                    'required' => true,
                                                                                    'query'    => $companyCategs));


    $this->widgetSchema->setLabels(array('parent_category'  => 'Parent Company Category'));
    $this->widgetSchema->setLabels(array('general_categ_id' => 'General Category'));



    //Company categ creation form
    $companyCategoryDescription = new CompanyCategoryDescription();
    $companyCategoryDescription->CompanyCategory = $this->getObject();
    $newCompanyCategDescriptionForm = new CompanyCategoryDescriptionForm($companyCategoryDescription);

    $this->embedForm('new', $newCompanyCategDescriptionForm);

    $this->embedRelation('CompanyCategoryDescription');


    //i18n (Internationalization)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('company_category_form');
  }

  protected function doBind(array $values)
  {
    if ('' === trim($values['new']['company_categ_description']) && '' === trim($values['new']['company_categ_name']))
    {
      unset($values['new'], $this['new']);
    }

    if (isset($values['CompanyCategoryDescription']))
    {
      foreach ($values['CompanyCategoryDescription'] as $i => $companyCategoryDescriptionValues)
      {
        if (isset($companyCategoryDescriptionValues['delete']) && $companyCategoryDescriptionValues['id'])
        {
          $this->scheduledForDeletion[$i] = $companyCategoryDescriptionValues['id'];
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
        unset($values['CompanyCategoryDescription'][$index]);
        unset($this->object['CompanyCategoryDescription'][$index]);
        Doctrine::getTable('CompanyCategoryDescription')->findOneById($id)->delete();
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


  /**
   * Overriding doSave method from lib/vendor/symfony/lib/form/addon/sfFormObject.class.php
   *
   * We need to save new objects in a Nested Tree where the object must have always a parent node
   * We retrieve the parent node id and insert the new object as a child of that node.
   *
   * @param mixed $con An optional connection object
   */
  protected function doSave($con = null)
  {
    //In this way we are writing on the database twice. Right now and the second one inserting the node as a child of its parent.
    parent::doSave($con);

    $companyCateg = CompanyCategoryTable::getInstance()->findOneById($this->values['parent_category']);
    //Second one, right here
    //First of all, we have to check if this node already has a parent
    if ($this->getObject()->getNode()->getParent() != null)
    {
        //We have to move the node
        $this->getObject()->getNode()->moveAsFirstChildOf($companyCateg);
    }
    else
    {
        //We have to insert the node
        $this->getObject()->getNode()->insertAsFirstChildOf($companyCateg);
    }
  }

 /**
  * Overriding updateDefaultsFromObject method from lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/form/sfFormDoctrine.class.php
  *
  */
  protected function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (!$this->getObject()->isNew())
    {
        $this->setDefault('parent_category', $this->getObject()->getNode()->getParent()->getId());
    }
  }
}
