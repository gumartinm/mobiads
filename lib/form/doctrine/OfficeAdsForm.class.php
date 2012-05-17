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
}
