<?php

/**
 * Custom office form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class OfficeForm extends BaseOfficeForm
{
  public function configure()
  {
    $this->useFields(array('city_id', 'office_street_address', 'office_zip'));



    $this->widgetSchema['longitude'] = new sfWidgetFormInputFloat();
    $this->widgetSchema['latitude'] = new sfWidgetFormInputFloat();


    $this->validatorSchema['longitude'] =  new sfValidatorNumber(array('max' => 180,
                                                                       'min' => -180,
                                                                       'required' => true,
                                                                       'trim' => true),
                                                                 array('invalid'  => 'Wrong Longitude',
                                                                       'required' => 'The longitude field is required',
                                                                       'max'      => 'Longitude "%value%" must not exceed the %max% value',
                                                                       'min'      => 'Longitude "%value%" must be equal or higher than %min%'));



    $this->validatorSchema['latitude'] = new sfValidatorNumber(array('max' => 90,
                                                                     'min' => -90,
                                                                     'required' => true,
                                                                     'trim' => true),
                                                               array('invalid'  => 'Wrong Latitude',
                                                                     'required' => 'The latitude field is required',
                                                                     'max'      => 'Latitude "%value%" must not exceed the %max% value',
                                                                     'min'      => 'Latitude "%value%" must be equal or higher than %min%'));

    $this->validatorSchema['city_id'] = new sfValidatorDoctrineChoice(array('model'    => $this->getRelatedModelName('City'),
                                                                            'required' => false,
                                                                            'query'    => $cityNamesQuery));



    $this->widgetSchema->setLabels(array('city_id'               => 'City: ',
                                         'longitude'             => 'Longitude (180 to -180): ',
                                         'latitude'              => 'Latitude (90 to -90): ',
                                         'office_street_address' => 'Address: ',
                                         'office_zip'            => 'ZIP:',));

    $this->validatorSchema->setOption('allow_extra_fields', false);
    $this->validatorSchema->setOption('filter_extra_fields', true);

    //i18n (Internationalization)
    //See apps/companyfront/modules/office/i18n/office_form.es.xml file
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('office_form');
  }


 /**
  * Overriding doSave method from lib/vendor/symfony/lib/form/addon/sfFormObject.class.php
  *
  * We are updating the data base in just 1 transaction
  * In case of unsetting longitude or latitude fields you will have to override this method.
  * TODO: create a Doctrine_Record for PostGIS
  */
  protected function doSave($con = null)
  {
    parent::doSave($con);

    //Get latitude and longitude values. They will be translated to GEOGRAPHIC data.
    foreach ($this->values as $field => $value)
    {
        if ($field == 'longitude')
            $longitude = $value;
        if ($field == 'latitude')
            $latitude = $value;
    }
    //Catch id element. We will use this id to insert the PostGIS value in the right row.
    $arrowId = $this->getObject()->getId();
    //Update PostGIS
    //This connection will throw exception in case of error.
    Doctrine_Manager::connection()->execute("UPDATE office SET office_gps=ST_GeographyFromText('SRID=4326;POINT($longitude $latitude)') WHERE id=$arrowId");
  }


 /**
  * Overriding updateDefaultsFromObject method from lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/form/sfFormDoctrine.class.php
  *
  * TODO: create a Doctrine_Record for PostGIS
  */
  protected function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    $this->setDefault('longitude', $this->getObject()->getLongitude());
    $this->setDefault('latitude', $this->getObject()->getLatitude());
  }
}
