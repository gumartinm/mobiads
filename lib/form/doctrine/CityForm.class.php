<?php

/**
 * City form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CityForm extends BaseCityForm
{
  public function configure()
  {
    unset($this['city_name']);

    $this->widgetSchema['region_id']->setAttribute('disabled', 'disabled');

    $this->embedRelation('Region');
  }
}
