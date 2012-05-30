<?php

/**
 * AdDescriptionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AdDescriptionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object AdDescriptionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('AdDescription');
    }


   /**
    * Returns ads with ad descriptions by company and language id.
    *
    * @return related ad to a company and language id as Doctrine Query
    */
    public function getAdsByCompanyandLanguageIdQuery($companyId, $languageId)
    {
        return $this->createQuery('addescription')->where('ad.company_id = ?', $companyId)
                                                  ->andWhere('addescription.language_id = ?', $languageId)
                                                  ->innerjoin('addescription.Ad ad')
                                                  ->orderBy('ad.id');
    }


    public function getAdsByGPSAndUserIdAndLanguageId(array $parameters, $userId, $languageId)
    {
        $longitude = $parameters['longitude'];
        $latitude = $parameters['latitude'];
        $longitude = str_replace(',', '.', $longitude);
        $latitude = str_replace(',', '.', $latitude);


        // I will use this style to retrieve the radius because this is an Academic Project and I want to learn the ins and outs of using Symfony.
        // I am wasting CPU cycles using this symfony helper. My Web Service will get worse cause this sentence. In production get the radius
        // from a constant value or something like that.
        $radius = sfConfig::get('app_radius', '100');

        try{
            $adIds = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchColumn(
                    "SELECT ad_id from office INNER JOIN office_ads ON (office_ads.office_id=office.id) 
                    WHERE ST_DWithin(office_gps, ST_GeographyFromText('SRID=4326;POINT($longitude $latitude)'), $radius)"
            );
        }
        catch (Exception $e)
        {
            //In case of error return as soon as posible.
            return null;
        }
        if (empty($adIds))
        {   //There are not offices with those GPS coordinates.
            //In many situations we will get this result, so a fast response.
            return null;
        }

        $uniqAdIds =  array_unique($adIds, SORT_NUMERIC);

        //We can not waste time doing this query. What is the best way to achieve this goal? 
        //Is a direct query the best way? With big tables I think this is not going to work.
        $adIds = array();
        foreach ($uniqAdIds as $uniqAdId)
        {
            try
            {
                $adIds[] = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchOne(
                    "SELECT ad.id FROM ad INNER JOIN company_category ON (ad.company_categ_id=company_category.id)
                    INNER JOIN general_category ON (company_category.general_categ_id=general_category.id)
                    INNER JOIN user_basket ON (user_basket.general_categ_id=general_category.id)
                    WHERE user_id=$userId AND ad.id=$uniqAdId"
                );
            }
            catch (Exception $e)
            {
                //In case of error return as soon as posible.
                return null;
            }
        }
        if (empty($adIds))
        {
            //There are not linked ads in those GPS coordinates with the specified user.
            return null;
        }
        $ads = array();
        foreach($adIds as $adId)
        {
            //Array with Doctrine_Records Ads
            $ad = $this->findOneByAdIdAndLanguageId($adId, $languageId);
            if ($ad != null)
            {
                $ads[] = $ad;
            }
            else
            {
                //Return with the default language
                $languageCode = sfConfig::get('app_default_language');
                $languageId = LanguageTable::getInstance()->findOneByCode($languageCode)->getId();
                $ad = $this->findOneByAdIdAndLanguageId($adId, $languageId);
                //This should never happen if every ad has at least the language by default.
                //TODO: Do not let the users create ads without the default language.
                if ($ad != null)
                {
                    $ads[] = $ad;
                }
            }
        }
        return $ads;
    }
}
