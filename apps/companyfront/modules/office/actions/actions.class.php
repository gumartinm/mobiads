<?php

/**
 * office actions.
 *
 * @package    mobiads
 * @subpackage office
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class officeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user
    //Just 1 user owns a company. Should this be improved?
    $companyId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    $this->offices = Doctrine_Core::getTable('Office')->findByCompanyId($companyId);

    $query=OfficeTable::getInstance()->getOfficesByCompanyIdQuery($companyId);

    $this->pager = new sfDoctrinePager('Office', sfConfig::get('app_max_offices_on_pager'));
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

  }

  public function executeShow(sfWebRequest $request)
  {
    $this->office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->office);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new OfficeForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $officeInit = new Office();

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $officeInit->company_id = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    $this->form = new OfficeForm($officeInit);

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id'))), sprintf('Object office does not exist (%s).', $request->getParameter('id')));

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    //Get id number sent by the user (never trust the users)
    $officeId = $request->getParameter('id');

    $companyOfficeId = OfficeTable::getInstance()->findOneById($officeId)->getCompanyId();

    $this->forward404Unless($companyOfficeId == $companyUserId, sprintf('Office does not exist (%s).', $request->getParameter('id')));

    $this->form = new OfficeForm($office);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id'))), sprintf('Object office does not exist (%s).', $request->getParameter('id')));

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    //Get id number sent by the user (never trust the users)
    $officeId = $request->getParameter('id');

    $companyOfficeId = OfficeTable::getInstance()->findOneById($officeId)->getCompanyId();

    $this->forward404Unless($companyOfficeId == $companyUserId, sprintf('Office does not exist (%s).', $request->getParameter('id')));

    $this->form = new OfficeForm($office);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id'))), sprintf('Object office does not exist (%s).', $request->getParameter('id')));

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    //Get id number sent by the user (never trust the users)
    $officeId = $request->getParameter('id');

    $companyOfficeId = OfficeTable::getInstance()->findOneById($officeId)->getCompanyId();

    $this->forward404Unless($companyOfficeId == $companyUserId, sprintf('Office does not exist (%s).', $request->getParameter('id')));

    $office->delete();

    $this->redirect('office/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $office = $form->save();

      $this->redirect('office/edit?id='.$office->getId());
    }
  }
}
