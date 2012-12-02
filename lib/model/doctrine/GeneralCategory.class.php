<?php

/**
 * GeneralCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    mobiads
 * @subpackage model
 * @author     Gustavo Martin Morcuende
 * @version
 */
class GeneralCategory extends BaseGeneralCategory
{
  /**
   * Returns the string representation of this object.
   *
   * @return string
   */
  public function __toString()
  {
    $user = sfContext::getInstance()->getUser();
    $generalCategoryDescriptions = GeneralCategoryDescriptionTable::getInstance()->findByGeneralCategId($this->getId());

    if ($user instanceof sfGuardSecurityUser)
    {
        $languageId = $user->getGuardUser()->getLanguage()->getId();

        //Check if there is description with the user's language
        foreach ($generalCategoryDescriptions as $generalCategoryDescription)
        {
            if ($generalCategoryDescription->getLanguageId() == $languageId)
            {
                //We found it!!!
                return (string) $generalCategoryDescription->getGeneralCategName();
            }
        }
    }

    //Otherwise return with the default language
    $languageCode = sfConfig::get('app_default_language');
    $languageId = LanguageTable::getInstance()->findOneByCode($languageCode)->getId();
    foreach ($generalCategoryDescriptions as $generalCategoryDescription)
    {
        if ($generalCategoryDescription->getLanguageId() == $languageId)
        {
           //We found the default name description!!!
           return (string) $generalCategoryDescription->getGeneralCategName();
        }
    }

    //Finally, if nothing was found, return nice error message.
    return (string) "General category without default language";
  }
}
