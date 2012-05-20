<?php

/**
 * CompanyCategoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CompanyCategoryTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CompanyCategoryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CompanyCategory');
    }


   /**
    * Returns company categories by company id.
    *
    * @return related company categories to a company as Doctrine Query
    */
    public function getCompanyCategoriesByCompanyIdQuery($companyId)
    {
        return $this->createQuery('cg')->where('cg.company_id = ?', $companyId)
                                       ->orWhere('cg.id = ?', '1')
                                       ->orderBy('cg.id');
    }
}
