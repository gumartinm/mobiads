<?php

/**
 * CompanyCategoryDescriptionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CompanyCategoryDescriptionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CompanyCategoryDescriptionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CompanyCategoryDescription');
    }


   /**
    * Return
    *
    * @return Doctrine Collection
    */
    public function getCategGeneralFromIdDAOImpl($languageId, $companyCategId)
    {
         $q = Doctrine_Query::create()
                        ->from('CompanyCategoryDescription cgd')
                        ->where('cgd.company_categ_id = ?', $companyCategId)
                        ->andWhere('cgd.language_id = ?', $languageId);

        $doccollect=$q->execute();

        return $doccollect;
    }
}
