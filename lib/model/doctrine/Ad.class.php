<?php

/**
 * Ad
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    mobiads
 * @subpackage model
 * @author     Gustavo Martin Morcuende
 * @version
 */
class Ad extends BaseAd
{
  /**
   * Returns the string representation of this object.
   *
   * @return string
   */
  public function __toString()
  {
    $languageId = sfContext::getInstance()->getUser()->getGuardUser()->getLanguage()->getId();

    //Check if there is description with the user's language
    $adDescriptions = AdDescriptionTable::getInstance()->findByAdId($this->getId());
    foreach ($adDescriptions as $adDescription)
    {
        if ($adDescription->getLanguageId() == $languageId)
        {
           //We found it!!!
           return (string) $adDescription->getAdName();
        }
    }

    //Otherwise return with the default language
    $languageCode = sfConfig::get('app_default_language');
    $languageId = LanguageTable::getInstance()->findOneByCode($languageCode)->getId();
    foreach ($adDescriptions as $adDescription)
    {
        if ($adDescription->getLanguageId() == $languageId)
        {
           //We found the default language!!!
           return (string) $adDescription->getAdName();
        }
    }

    //Finally, if nothing was found, return nice error message.
    return (string) "Ad without default language";
  }

    public function getGpsST_AsText()
    {
        $aux=$this->getAdGps();
        if ($aux)
        {
            //Using a PostGIS query to convert a GIS value? This is a bit strange
            $results=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchColumn("SELECT ST_AsText('$aux')");
            return trim($results['0'], "POINT()");
        }
        else
            return 0;
    }

    public function getLongitude()
    {
        $gpsST_AsText=$this->getGpsST_AsText();

        $longitude = strstr($gpsST_AsText, ' ', true);

        return $longitude;
    }

    public function getLatitude()
    {
        $gpsST_AsText=$this->getGpsST_AsText();

        $latitude = strstr($gpsST_AsText, ' ');

        return $latitude;
    }
}
