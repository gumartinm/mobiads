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
    $this->useFields(array('company_categ_id', 'ad_mobile_image'));

    //Narrow down the valid options for some field validators
    $companyCategs = CompanyCategoryTable::getInstance()->getCompanyCategoriesByCompanyIdQuerySkipMain($this->getOption('company_user_id'));

    //The default value is not good enough for us. We need narrow down the results.
    $this->widgetSchema['company_categ_id'] = new sfWidgetFormDoctrineChoice(array('model'    => $this->getModelName(),
                                                                                  'add_empty' => true,
                                                                                  'query'     => $companyCategs));

    $this->validatorSchema['company_categ_id'] = new sfValidatorDoctrineChoice(array('model'   => $this->getModelName(),
                                                                                    'required' => false,
                                                                                    'query'    => $companyCategs));


    $this->widgetSchema['ad_mobile_image'] =
                new sfWidgetFormInputFileEditable(array('file_src'    => '/uploads/images/'.$this->getObject()->ad_mobile_image,
                                                        'edit_mode'   => !$this->isNew(),
                                                        'is_image'    => true,
                                                        'with_delete' => false));


    $this->validatorSchema['ad_mobile_image'] = new sfValidatorFileImage(array('mime_types' => 'web_images',
                                                                                    'path' => sfConfig::get('app_default_picture_directory'),
                                                                                    'required' => $this->isNew(),
                                                                                    'is_only_image' => true,
                                                                                    'max_height' => 156,
                                                                                    'min_height' => 128,
                                                                                    'max_width' => 156,
                                                                                    'min_width' => 128,
                                  'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif','application/x-shockwave-flash')));

    $this->widgetSchema['longitude'] = new sfWidgetFormInputFloat();
    $this->widgetSchema['latitude'] = new sfWidgetFormInputFloat();


    $this->validatorSchema['longitude'] =  new sfValidatorNumber(array('max' => 180,
                                                                       'min' => -180,
                                                                       'required' => false,
                                                                       'trim' => true),
                                                                 array('invalid'  => 'Wrong Longitude',
                                                                       'max'      => 'Longitude "%value%" must not exceed the %max% value',
                                                                       'min'      => 'Longitude "%value%" must be equal or higher than %min%'));



    $this->validatorSchema['latitude'] = new sfValidatorNumber(array('max' => 90,
                                                                     'min' => -90,
                                                                     'required' => false,
                                                                     'trim' => true),
                                                               array('invalid'  => 'Wrong Latitude',
                                                                     'max'      => 'Latitude "%value%" must not exceed the %max% value',
                                                                     'min'      => 'Latitude "%value%" must be equal or higher than %min%'));




    $this->widgetSchema->setLabels(array('company_categ_id'  => 'Company Category'));
    $this->widgetSchema->setLabels(array('ad_mobile_image' => "Picture on the user's mobile"));
    $this->widgetSchema->setLabels(array('longitude'  => 'Longitude (180 to -180): '));
    $this->widgetSchema->setLabels(array('latitude'  => 'Latitude (90 to -90): '));



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
    if (isset($values['new']))
    {
        if ('' === trim($values['new']['ad_mobile_text']) && '' === trim($values['new']['ad_name']) && 
            '' === trim($values['new']['ad_link']))
        {
            unset($values['new'], $this['new']);
        }
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
    $rowId = $this->getObject()->getId();
    //They are not required fields, so they could be null values.
    if ((isset($longitude)) && (isset($latitude)))
    {
        //Update PostGIS with the chosen coordinates.
        //This connection will throw exception in case of error.
        Doctrine_Manager::connection()->execute("UPDATE ad SET ad_gps=ST_GeographyFromText('SRID=4326;POINT($longitude $latitude)') WHERE id=$rowId");
    }
    else {
        //Update PostGIS with null value (no GPS coordinates)
        Doctrine_Manager::connection()->execute("UPDATE ad SET ad_gps=null WHERE id=$rowId");
    }   
  }
}
