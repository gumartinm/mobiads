<?php

/**
 * OfficeAds form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class OfficeAdsForm extends BaseOfficeAdsForm
{
  /*Stores Doctrine Records to be saved in the database.*/
  protected $scheduledForSaving = array();
  /*Stores Doctrine Records to be removed from the database.*/
  protected $scheduledForDeletion = array();


  public function configure()
  {
    //Narrow down options.
    //We must just show those ads owned by the office's company.
    $query = AdTable::getInstance()->getAdsByCompanyIdQuery($this->getOption('companyId'));

    $this->useFields(array('ad_id'));

    $this->widgetSchema['ad_id'] = new sfWidgetFormDoctrineChoice(array('model'          => $this->getRelatedModelName('Ad'),
                                                                        'add_empty'      => false,
                                                                        'multiple'       => true,
                                                                        'expanded'       => false,
                                                                        'renderer_class' => 'sfWidgetFormSelectDoubleList',
                                                                        'query'          => $query));


    $this->validatorSchema['ad_id'] =  new sfValidatorDoctrineChoice(array('model'    => $this->getRelatedModelName('Ad'),
                                                                           'multiple' => true,
                                                                           'query'    => $query));
    $this->widgetSchema->setLabel('ad_id', false);

    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('office_ads_form');
  }

 /**
  * Overriding updateDefaultsFromObject method in order to preselect fields.
  *
  * The already chosen ads must be shown as selected.
  * see: lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/form/sfFormDoctrine.class.php
  */
  protected function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    //We just preselect fields when the Doctrine Record Object comes from the data base.
    if (!$this->getObject()->isNew())
    {
        $officeAds = OfficeAdsTable::getInstance()->findByOfficeId($this->getObject()->getOfficeId());
        foreach ($officeAds as $officeAd)
        {
            $already_chosen[] = $officeAd->getAdId();
        }
        $this->setDefault('ad_id', $already_chosen);
    }
  }


 /**
  * Overriding doSave method from lib/vendor/symfony/lib/form/addon/sfFormObject.class.php
  *
  * We are updating the data base in just 1 transaction
  */
  protected function doSave($con = null)
  {

    if (null === $con)
    {
      $con = $this->getConnection();
    }
   
 
    foreach ($this->scheduledForSaving as $index => $value)
    {
        $value->save($con);
    }
    foreach ($this->scheduledForDeletion as $index => $value)
    {
        $value->delete($con);
    }

  }


 /**
  * Overriding doBind method
  *
  * TODO: I am breaking the validations. How could I do this in a right way?
  */
  protected function doBind(array $values)
  {
    $officeAds = OfficeAdsTable::getInstance()->findByOfficeId($this->getObject()->getOfficeId());

    //Scheduled for delete
    //If the object was previously in the database.
    if (!$this->getObject()->isNew())
    {
        //The Doctrine Collection must not be null because the object was previously in the data base.
        //We must search the whole Doctrine Collection in order to find out if the object was in the database
        //and it has been chosen for the user to stay in the database.
        foreach ($officeAds as $index => $officeAd)
        {
            //If the user chose something to associate with.
            if (isset($values['ad_id']))
            {
                foreach ($values['ad_id'] as $value)
                {
                    //That ad has been found in the database, so it is not going to be removed.
                    if ($officeAd->getAdId() == $value)
                        continue 2;
                }
            }
            //The user did not choose this ad which was previously in the database, so we have to remove it.
            $this->scheduledForDeletion[$index] = $officeAd;
        }
    }

    //Scheduled for save
    if (isset($values['ad_id']))
    {
        //We must search the whole array in order to find out if the chosen ad is in the database or not.
        //If the object was not previously in the database we must save it, otherwise we do nothing.
        foreach ($values['ad_id'] as $index => $value)
        {
            //If the object was previously in the database.
            if (!$this->getObject()->isNew())
            {
                foreach ($officeAds as $officeAd)
                {
                    //The ad has been found in the database, it is not going to be saved again.
                    if ($officeAd->getAdId() == $value)
                        continue 2;
                }
            }
            //The user chose another ad to be stored in the database.
            $newOfficeAds = new OfficeAds();
            $newOfficeAds->office_id = $this->getObject()->getOfficeId();
            $newOfficeAds->ad_id = $value;
            $this->scheduledForSaving[$index] = $newOfficeAds;
        }
    }
  }
}
