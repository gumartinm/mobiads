<?php

/**
 * category actions.
 *
 * @package    mobiads
 * @subpackage category
 * @author     Gustavo Martin Morcuende
 * @version
 */
class categoryActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user
    //Just 1 user owns a company. Should this be improved?
    $companyId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    //Doctrine Query used to show a pager with the Company Categories.
    $query=CompanyCategoryTable::getInstance()->getCompanyCategoriesByCompanyIdQuery($companyId);

    $this->pager = new sfDoctrinePager('CompanyCategoryDescription', sfConfig::get('app_max_categories_on_pager'));
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->company_category = Doctrine_Core::getTable('CompanyCategory')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->company_category);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CompanyCategoryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CompanyCategoryForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($company_category = Doctrine_Core::getTable('CompanyCategory')->find(array($request->getParameter('id'))), sprintf('Object company_category does not exist (%s).', $request->getParameter('id')));
    $this->form = new CompanyCategoryForm($company_category);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($company_category = Doctrine_Core::getTable('CompanyCategory')->find(array($request->getParameter('id'))), sprintf('Object company_category does not exist (%s).', $request->getParameter('id')));
    $this->form = new CompanyCategoryForm($company_category);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($company_category = Doctrine_Core::getTable('CompanyCategory')->find(array($request->getParameter('id'))), sprintf('Object company_category does not exist (%s).', $request->getParameter('id')));
    $company_category->delete();

    $this->redirect('category/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $company_category = $form->save();

      $this->redirect('category/edit?id='.$company_category->getId());
    }
  }
}
