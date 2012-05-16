<?php

/**
 * ad actions.
 *
 * @package    mobiads
 * @subpackage ad
 * @author     Gustavo Martin Morcuende
 * @version
 */
class adActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
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

    
    //Init combobox with the right value.
    $this->formLanguage = new LanguageListForm($language);


    //Doctrine Query used to show a pager with the Ads.
    $query=AdDescriptionTable::getInstance()->getAdsByCompanyandLanguageIdQuery($companyId, $language->getId());


    $this->pager = new sfDoctrinePager('AdDescription', sfConfig::get('app_max_ads_on_pager'));
    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();


    $this->userLanguageId = $this->getUser()->getGuardUser()->getLanguage()->getId();
    $this->languageCode = $language->getCode();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->ad = Doctrine_Core::getTable('Ad')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->ad);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AdForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new AdForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($ad = Doctrine_Core::getTable('Ad')->find(array($request->getParameter('id'))), sprintf('Object ad does not exist (%s).', $request->getParameter('id')));
    $this->form = new AdForm($ad);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($ad = Doctrine_Core::getTable('Ad')->find(array($request->getParameter('id'))), sprintf('Object ad does not exist (%s).', $request->getParameter('id')));
    $this->form = new AdForm($ad);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($ad = Doctrine_Core::getTable('Ad')->find(array($request->getParameter('id'))), sprintf('Object ad does not exist (%s).', $request->getParameter('id')));
    $ad->delete();

    $this->redirect('ad/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $ad = $form->save();

      $this->redirect('ad/edit?id='.$ad->getId());
    }
  }

  public function executeIndexLanguage(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $formLanguage = new LanguageListForm();

    //Retrieve post parameters
    $postArray = $request->getPostParameter($formLanguage->getName());

    //Retrieve Doctrine Record related to the chosen language
    $language = LanguageTable::getInstance()->findOneById($postArray['id']);

    $this->forward404Unless($language != null, sprintf('Language does not exist'));

    $formLanguage = new LanguageListForm($language);

    $formLanguage->bind($request->getParameter($formLanguage->getName()), $request->getFiles($formLanguage->getName()));
    if ($formLanguage->isValid())
    {
        $this->redirect('ad/index?language='.$language->getCode());
    }
    
    //By default current user's language
    $this->redirect('ad/index?language='.$this->getUser()->getGuardUser()->getLanguage()->getCode());
  }
}
