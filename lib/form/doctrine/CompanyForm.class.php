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
  public function configure()
  {
    $this->useFields(array('company_cif','company_name'));


    $this->widgetSchema['company_logo'] =
                new sfWidgetFormInputFileEditable(array('file_src'    => '/uploads/images/'.$this->getObject()->company_logo,
                                                        'edit_mode'   => !$this->isNew(),
                                                        'is_image'    => true,
                                                        'with_delete' => false));



    $this->validatorSchema['company_logo'] = new sfValidatorFileImage(array('path' => sfConfig::get('app_default_picture_directory'),
                                                                            'required' => $this->isNew(),
                                                                            'is_only_image' => true,
                                                                            'max_height' => 150,
                                                                            'min_height' => 128,
                                                                            'max_width' => 150,
                                                                            'min_width' => 128,
                                  'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif','application/x-shockwave-flash')));



    $this->widgetSchema->setLabels(array('company_cif' => 'CIF: '));
    $this->widgetSchema->setLabels(array('company_logo' => "Your company logo: "));
    $this->widgetSchema->setLabels(array('company_name' => "Your company name: "));


    //i18n (Internationalization)
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('company_form');
  }
}
