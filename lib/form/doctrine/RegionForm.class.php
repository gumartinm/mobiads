<?php

/**
 * Region form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class RegionForm extends BaseRegionForm
{
  public function configure()
  {
    unset($this['region_name']);

    $this->widgetSchema['country_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'),
                                                                             'add_empty' => true));

    $this->embedRelation('Country');
  }
}
