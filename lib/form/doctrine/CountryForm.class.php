<?php

/**
 * Country form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class CountryForm extends BaseCountryForm
{
  public function configure()
  {
    unset($this['iso_code_2']);
    unset($this['iso_code_3']);
    unset($this['country_name']);
  }
}
