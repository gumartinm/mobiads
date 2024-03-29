<?php

/**
 * office actions.
 *
 * @package    mobiads
 * @subpackage office
 * @author     Gustavo Martin Morcuende
 * @version
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

    //Sort list
    $this->sort = $request->getParameter('sort', 'id');
    $orderBy = $this->validateSort($this->sort); 
    
    $query=OfficeTable::getInstance()->getOfficesByCompanyIdWithSortQuery($companyId, $orderBy);

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
    $this->sort = $request->getParameter('sort', 'id');
    $this->page = $request->getParameter('page', 1);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $officeInit = new Office();

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $officeInit->company_id = CompanyTable::getInstance()->findOneByUserId($userId)->getId();
    $officeInit->city_id = null;

    $officeParameters = $request->getParameter('office');
    //Never trust data coming from users.
    $cityId = 1;
    if ($officeParameters['city_id'])
    {
        $cityId = $officeParameters['city_id'];
    }
    $city = CityTable::getInstance()->findOneById($cityId);
    $regionId = $city->getRegion()->getId();
    $countryId = $city->getRegion()->getCountry()->getId();

    $this->form = new OfficeForm($officeInit, array('region_id' => $regionId, 'country_id' => $countryId));

    $this->sort = $request->getParameter('sort', 'id');
    $this->page = $request->getParameter('page', 1);

    $this->processForm($request, $this->form, $this->sort, $this->page);

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

    $this->sort = $request->getParameter('sort', 'id');
    $this->page = $request->getParameter('page', 1);

    $regionId = $office->getCity()->getRegion()->getId();
    $countryId = $office->getCity()->getRegion()->getCountry()->getId();

    $this->form = new OfficeForm($office, array('region_id' => $regionId, 'country_id' => $countryId));
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

    $this->sort = $request->getParameter('sort', 'id');
    $this->page = $request->getParameter('page', 1);

    $this->processForm($request, $this->form, $this->sort, $this->page);

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

    $sort = $request->getParameter('sort', 'id');
    $page = $request->getParameter('page', 1);

    $this->redirect('office/index?page='.$page.'&sort='.$sort);
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $sort, $page)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $office = $form->save();

      $this->redirect('office/edit?id='.$office->getId().'&page='.$page.'&sort='.$sort);
    }
  }

  public function executeLink(sfWebRequest $request)
  {
    $this->forward404Unless($office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id'))), sprintf('Object office does not exist (%s).', $request->getParameter('id')));

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    //Get id number sent by the user (never trust the users)
    $officeId = $request->getParameter('id');

    $companyOfficeId = $office->getCompanyId();

    $this->forward404Unless($companyOfficeId == $companyUserId, sprintf('Office does not exist (%s).', $request->getParameter('id')));

    $officeAds = OfficeAdsTable::getInstance()->findOneByOfficeId($officeId);

    $this->form = new OfficeAdsForm($officeAds, array('companyId' => $companyOfficeId));

    $this->sort = $request->getParameter('sort', 'id');
    $this->page = $request->getParameter('page', 1);
    $this->officeId = $officeId;
  }

  public function executeCreateLink(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $officeId = $request->getParameter('officeId');

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();


    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();
    //Get company owned by that user and insert value in form
    $companyOfficeId = OfficeTable::getInstance()->findOneById($officeId)->getCompanyId();

    $this->forward404Unless($companyOfficeId == $companyUserId, sprintf('Office does not exist (%s).', $request->getParameter('officeId')));

    $officeAdsInit = new OfficeAds();
    $officeAdsInit->office_id = $officeId;

    $this->form = new OfficeAdsForm($officeAdsInit, array('companyId' => $companyOfficeId));

    $this->sort = $request->getParameter('sort', 'id');
    $this->page = $request->getParameter('page', 1);
    $this->officeId = $officeId;

    $this->processAdsForm($request, $this->form, $this->sort, $this->page);

    $this->setTemplate('link');
  }

  public function executeUpdateLink(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($officeAds = Doctrine_Core::getTable('OfficeAds')->find(array($request->getParameter('id'))), sprintf('Object office ads does not exist (%s).', $request->getParameter('id')));

    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get company owned by that user and insert value in form
    $companyUserId = CompanyTable::getInstance()->findOneByUserId($userId)->getId();

    //Get id number sent by the user (never trust the users)
    $officeAdsId = $request->getParameter('id');
    $companyOfficeId = OfficeAdsTable::getInstance()->findOneById($officeAdsId)->getOffice()->getCompanyId();

    $this->forward404Unless($companyOfficeId == $companyUserId, sprintf('Office does not exist (%s).', $request->getParameter('id')));


    $this->form = new OfficeAdsForm($officeAds, array('companyId' => $companyOfficeId));

    $this->sort = $request->getParameter('sort', 'id');
    $this->page = $request->getParameter('page', 1);
    $this->officeId = $officeAds->getOfficeId();

    $this->processAdsForm($request, $this->form, $this->sort, $this->page);

    $this->setTemplate('link');
  }


  protected function processAdsForm(sfWebRequest $request, sfForm $form, $sort, $page)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $officeAds = $form->save();

      $this->redirect('office/link?id='.$officeAds->getOfficeId().'&page='.$page.'&sort='.$sort);
    }
  }


 /**
  * We must validate the data coming from the user.
  *
  * @param sort value as string
  * @return custom sort value, the office id by default
  */
  private function validateSort($sort)
  {
    switch ($sort) {
        case "country":
            $orderBy = "country.id";
            break;
        case "region":
            $orderBy = "region.id";
            break;
        case "city":
            $orderBy = "city.id";
            break;
        case "address":
            $orderBy = "office_street_address";
            break;
        case "zip":
            $orderBy = "office_zip";
            break;
        default:
            $orderBy = "office.id";
    }
    
    return $orderBy;
  }

 /**
  * Run action from JQuery POST while chosing the country in the select HTML field
  * for offices creation and edition.
  *
  * @param sfWebRequest with the chosen country
  */
  public function executeChosencountry(sfWebRequest $request)
  {
    $countryId = $request->getParameter('countryId');

    //Never trust data coming from user
    if (!isset($countryId))
    {
        //Incorrect data from user. Using default value.
        $country = CountryTable::getInstance()->findOnebyCountryName(sfConfig::get('app_default_country'));
    }
    else 
    {
        $country = CountryTable::getInstance()->findOneById($countryId);
        if (!isset($country))
        {
            //Incorrect data from user. Using default value.
            $country = CountryTable::getInstance()->findOnebyCountryName(sfConfig::get('app_default_country'));
        }
    }

    $regionsJSON = array();
    //Retrieve Doctrine_Collection
    $regions = RegionTable::getInstance()->findByCountryId($country->getId());
    //Using Doctrine_Collection_Iterator
    $iterator = $regions->getIterator();
    while ($region = $iterator->current())
    {
        $regionsJSON[$region->getId()] = $region->getRegionName();
        $iterator->next();
    }


    //set content type HTTP field  with the right value (we are going to use a JSON response)
    $this->getResponse()->setContentType('application/json');

    //Bypass completely the view layer and set the response code directly from this action.
    //In this way the user may know if the data were updated
    return $this->renderText(json_encode($regionsJSON));
  }

 /**
  * Run action from JQuery POST while chosing the region in the select HTML field
  * for offices creation and edition.
  *
  * @param sfWebRequest with the chosen region
  */
  public function executeChosenregion(sfWebRequest $request)
  {
    $regionId = $request->getParameter('regionId');

    //set content type HTTP field  with the right value (we are going to use a JSON response)
    $this->getResponse()->setContentType('application/json');


    //Never trust data coming from user
    if (!isset($regionId))
    {
        //Incorrect data from user.
        //TODO: JSON error
        return $this->renderText(json_encode("")); 
    }
    else
    {
        $region = RegionTable::getInstance()->findOneById($regionId);
        if (!isset($region))
        {
            //Incorrect data from user.
            //TODO: JSON error
            return $this->renderText(json_encode(""));
        }
    }

    $citiesJSON = array();
    //Retrieve Doctrine_Collection
    $cities = CityTable::getInstance()->findByRegionId($region->getId());
    //Using Doctrine_Collection_Iterator
    $iterator = $cities->getIterator();
    while ($city = $iterator->current())
    {
        $citiesJSON[$city->getId()] = $city->getCityName();
        $iterator->next();
    }


    //Bypass completely the view layer and set the response code directly from this action.
    //In this way the user may know if the data were updated
    return $this->renderText(json_encode($citiesJSON));
  }
}
