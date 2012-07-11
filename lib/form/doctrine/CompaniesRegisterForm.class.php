<?php

/**
 * CompaniesRegisterForm for registering new users
 *
 * @package    mobileadvertising
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version
 */
class CompaniesRegisterForm extends UsersRegisterForm
{
  /**
   * @see sfForm
   */
  public function configure()
  { 
    //Company creation form
    $company = new Company();
    $company->User = $this->getObject();
    $newCompanyForm = new CompanyForm($company);

    $this->embedForm('new', $newCompanyForm);

    $this->embedRelation('Company');

    parent::configure();
  }   
} 
