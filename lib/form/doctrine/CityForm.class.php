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

    $this->widgetSchema['region_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 
                                                                            'add_empty' => true));

    if($this->isNew())
    {
        $this->widgetSchema['region_id']->setAttribute('disabled', 'disabled');
    }

    $this->embedRelation('Region');
  }
}
