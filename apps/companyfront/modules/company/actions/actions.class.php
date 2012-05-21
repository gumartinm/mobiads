<?php

/**
 * company actions.
 *
 * @package    mobiads
 * @subpackage company
 * @author     Gustavo Martin Morcuende
 * @version
 */
class companyActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->companys = Doctrine_Core::getTable('Company')
      ->createQuery('a')
      ->execute();


    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user
    //Just 1 user owns a company. Should this be improved?
    $companyId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    $languageCode = $request->getParameter('language');
    if ($languageCode != null)
    {
        $language = LanguageTable::getInstance()->findOneByCode($languageCode);
        if ($language == null)
        {
            //By default we use the current user's language.
            $language = $this->getUser()->getGuardUser()->getLanguage();
        }
    }
    else
    {
        //By default we use the current user's language.
        $language = $this->getUser()->getGuardUser()->getLanguage();
    }

    //Retrieve Doctrine Record (just one company for user)
    $this->company = CompanyDescriptionTable::getInstance()->findOneByCompanyIdAndLanguageId($companyId, $language->getId());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->company = Doctrine_Core::getTable('Company')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->company);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CompanyForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CompanyForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($company = Doctrine_Core::getTable('Company')->find(array($request->getParameter('id'))), sprintf('Object company does not exist (%s).', $request->getParameter('id')));

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

     //Get id number sent by the user (never trust the users)
    $id = $request->getParameter('id');

    $companyId = CompanyTable::getInstance()->findOneById($id)->getId();

    $this->forward404Unless($companyId == $companyUserId, sprintf('Company does not exist (%s).', $request->getParameter('id')));

    $this->form = new CompanyForm($company);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($company = Doctrine_Core::getTable('Company')->find(array($request->getParameter('id'))), sprintf('Object company does not exist (%s).', $request->getParameter('id')));

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

     //Get id number sent by the user (never trust the users)
    $id = $request->getParameter('id');

    $companyId = CompanyTable::getInstance()->findOneById($id)->getId();

    $this->forward404Unless($companyId == $companyUserId, sprintf('Company does not exist (%s).', $request->getParameter('id')));

    $this->form = new CompanyForm($company);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($company = Doctrine_Core::getTable('Company')->find(array($request->getParameter('id'))), sprintf('Object company does not exist (%s).', $request->getParameter('id')));
    $company->delete();

    $this->redirect('company/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $company = $form->save();

      $this->redirect('company/edit?id='.$company->getId());
    }
  }
}
