<?php

/**
 * City form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class CityForm extends BaseCityForm
{
  public function configure()
  {
    unset($this['city_name']);

    //Narrow down the valid options for some field validators
    $regionsQuery = null;
    if ($this->getOption('country_id'))
    {
        $regionsQuery = RegionTable::getInstance()->getRegionsByCountryIdQuery($this->getOption('country_id'));
    }

    $this->widgetSchema['region_id'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getRelatedModelName('Region'),
                                                                            'add_empty' => true,
                                                                            'query'     => $regionsQuery));

    if($this->isNew())
    {
        $this->widgetSchema['region_id']->setAttribute('disabled', 'disabled');
    }

    $this->embedRelation('Region');
  }
}
