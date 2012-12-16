<?php

/**
 * AdDescription form.
 *
 * @package    mobiads
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class AdDescriptionForm extends BaseAdDescriptionForm
{
  public function configure()
  {
    unset($this['ad_id']);
    unset($this['ad_description']);


    $this->widgetSchema['ad_link'] = new sfWidgetFormInputText();

    if ($this->isNew())
    {
        $query = LanguageTable::getInstance()->getLanguagesQuery($this->availableLanguages());

        $this->widgetSchema['language_id'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getRelatedModelName('Language'),
                                                                                  'add_empty' => false,
                                                                                  'query'     => $query));


        $this->validatorSchema['language_id'] = new sfValidatorDoctrineChoice(array('model'    => $this->getRelatedModelName('Language'),
                                                                                    'required' => true,
                                                                                    'query'    => $query));
    }
    else {
        $query = LanguageTable::getInstance()->getLanguagesQuery($this->getObject()->getLanguageId());

        $this->widgetSchema['language_id'] = new sfWidgetFormDoctrineChoice(array('model'     => $this->getRelatedModelName('Language'),
                                                                                  'add_empty' => false,
                                                                                   'query'    => $query));


        $this->validatorSchema['language_id'] = new sfValidatorDoctrineChoice(array('model'    => $this->getRelatedModelName('Language'),
                                                                                    'required' => true,
                                                                                    'query'    => $query));
    }

    if ($this->object->exists())
    {
      $this->widgetSchema['delete'] = new sfWidgetFormInputCheckbox();
      $this->validatorSchema['delete'] = new sfValidatorPass();
    }
  }

  /**
   * Retrieve the available language's ids.
   *
   * @return array an array with the available languages' ids.
   */
  private function availableLanguages()
  {
    //Doctrine_Collection with all our languages
    $languages = LanguageTable::getInstance()->findAll();

    //Using Doctrine_Collection_Iterator
    $iterator = $languages->getIterator();

    //Doctrine_Collection with the current descriptions for our ad
    //When creating the first time a new ad there is not Doctrine_Row for this ad in the Ad Table.
    //We check that edge condition.
    if ($this->getObject()->getAd()->exists())
    {
        $adDescriptions = AdDescriptionTable::getInstance()->findByAdId($this->getObject()->getAdId());
    }
    else
    {
        $adDescriptions = array();
    }

    $availableLanguages = array();

    while ($language = $iterator->current())
    {
        $match = false;
        foreach ($adDescriptions as $adDescription)
        {
            if ($adDescription->getLanguageId() == $language->getId())
            {
                //There is a match
                $match = true;
                break;
            }
        }
        if (!$match)
        {
            $availableLanguages[] = $language->getId();
        }
        $iterator->next();
    }

    return $availableLanguages;
  }
}
