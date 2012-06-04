<?php

/**
 * Country form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
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
