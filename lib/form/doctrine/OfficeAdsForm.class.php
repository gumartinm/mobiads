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
  protected $scheduledForSave = array();


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

    $this->widgetSchema->setLabels(array('city_id'               => 'City: ',
                                         'longitude'             => 'Longitude (180 to -180): ',
                                         'latitude'              => 'Latitude (90 to -90): ',
                                         'office_street_address' => 'Address: ',
                                         'office_zip'            => 'ZIP:',));


    $this->validatorSchema['ad_id'] =  new sfValidatorDoctrineChoice(array('model'    => $this->getRelatedModelName('Ad'),
                                                                           'multiple' => true,
                                                                           'query'    => $query));

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
   
 
    foreach ($this->scheduledForSave as $index => $value)
    {
        $value->save($con);
    }
  }


 /**
  * Overriding doBind method
  *
  * TODO: I am breaking the validations. How could I do this in a right way?
  */  
  protected function doBind(array $values)
  {
    if (!isset($values['ad_id']))
    {
        if (!$this->getObject()->isNew())
        { 
            $officeAds = OfficeAdsTable::getInstance()->findByOfficeId($this->getObject()->getOfficeId());
           
            foreach ($officeAds as $officeAd)
            { 
                $officeAd->delete();
            }
        }    
        return;
    }

    $officeAds = OfficeAdsTable::getInstance()->findByOfficeId($this->getObject()->getOfficeId());

    foreach ($values['ad_id'] as $index => $value)
    {
        if (!$this->getObject()->isNew())
        { 
            foreach ($officeAds as $officeAd)
            {
                if ($officeAd->getAdId() == $value)
                    continue 2;
            }
        }
        $officeAds = new OfficeAds();
        $officeAds->office_id = $this->getObject()->getOfficeId();
        $officeAds->ad_id = $value;
        $this->scheduledForSave[$index] = $officeAds;
    }
  }
}
