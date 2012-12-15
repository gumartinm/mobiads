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
    $this->useFields(array('general_categ_id', 'company_categ_name', 'company_categ_description'));

    //Narrow down the valid options for some field validators
    $companyCategs = CompanyCategoryTable::getInstance()->getCompanyCategoriesByCompanyIdQuery($this->getOption('company_user_id'),
                                                                                               $this->getOption('current_category'),
                                                                                               $this->getOption('current_category_lft'),
                                                                                               $this->getOption('current_category_rgt'));

    $this->widgetSchema['parent_category'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getModelName(),
                                                                                  'add_empty' => false,
                                                                                  'query'     => $companyCategs));

    $this->widgetSchema['general_categ_id'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getRelatedModelName('GeneralCategory'),
                                                                                   'add_empty' => true,
                                                                                   'query'     => GeneralCategoryTable::getInstance()->getGeneralCategoriesByLftQuery()));


    $this->widgetSchema['company_categ_description'] = new sfWidgetFormTextarea();

    $this->validatorSchema['parent_category'] = new sfValidatorDoctrineChoice(array('model'    => $this->getModelName(),
                                                                                    'required' => true,
                                                                                    'query'    => $companyCategs));

    $this->validatorSchema['general_categ_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GeneralCategory'),
                                                                                     'required' => false,
                                                                                     'query'     => GeneralCategoryTable::getInstance()->getGeneralCategoriesByLftQuery()));



    $this->widgetSchema->setLabels(array('parent_category'  => 'Parent Company Category'));
    $this->widgetSchema->setLabels(array('general_categ_id' => 'General Category'));
    $this->widgetSchema->setLabels(array('company_categ_name'  => 'Company Category Name'));
    $this->widgetSchema->setLabels(array('company_categ_description' => 'Company Category Description'));


    //i18n (Internationalization)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('company_category_form');
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
