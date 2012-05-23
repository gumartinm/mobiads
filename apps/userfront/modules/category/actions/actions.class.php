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
    $this->userId = $this->getUser()->getGuardUser()->getId();

    //Doctrine Query used to show a list with the General Categories (execute returns a Doctrine Collection of Doctrine Records)
    $this->generalCategories = $query=GeneralCategoryTable::getInstance()->getGeneralCategoriesByLftQuery()->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->general_category = Doctrine_Core::getTable('GeneralCategory')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->general_category);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new GeneralCategoryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new GeneralCategoryForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($general_category = Doctrine_Core::getTable('GeneralCategory')->find(array($request->getParameter('id'))), sprintf('Object general_category does not exist (%s).', $request->getParameter('id')));
    $this->form = new GeneralCategoryForm($general_category);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($general_category = Doctrine_Core::getTable('GeneralCategory')->find(array($request->getParameter('id'))), sprintf('Object general_category does not exist (%s).', $request->getParameter('id')));
    $this->form = new GeneralCategoryForm($general_category);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($general_category = Doctrine_Core::getTable('GeneralCategory')->find(array($request->getParameter('id'))), sprintf('Object general_category does not exist (%s).', $request->getParameter('id')));
    $general_category->delete();

    $this->redirect('category/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $general_category = $form->save();

      $this->redirect('category/edit?id='.$general_category->getId());
    }
  }

  public function executeChoose($request)
  {
    //Get user Id
    $userId = $this->getUser()->getGuardUser()->getId();

    //Get data from user
    $checked = $request->getParameter('checked');

    $uniqChecked =  array_unique($checked, SORT_NUMERIC);

    //We retrieve a Doctrine_Collection
    $userBaskets = UserBasketTable::getInstance()->findByUserId($userId);


    //Using Doctrine_Collection_Iterator
    $iterator = $userBaskets->getIterator();
    while ($userBasket = $iterator->current())
    {
        if (!empty($uniqChecked))
        {
            foreach ($uniqChecked as $index => $value)
            {
                if ($userBasket->getGeneralCategId() == $value)
                {
                    unset($uniqChecked[$index]);
                    $iterator->next();
                    continue 2;
                }
            }
        }
        $userBaskets->remove($iterator->key());
        $iterator->next();
    }

    if (!empty($uniqChecked))
    {
        foreach ($uniqChecked as $index => $value)
        {
            //Never trust in data coming from users... Performance vs security.
            $generalCategory = GeneralCategoryTable::getInstance()->findOneById($value);
            if ($generalCategory != null)
            {
                $userBasket = new UserBasket();
                $userBasket->general_categ_id = $generalCategory->getId();
                $userBasket->user_id = $userId;
                $userBaskets->add($userBasket);
            }
        }
    }

    //The Doctrine_Collection should just insert/remove in the database in this point (never before)
    //This feature is really nice (if it works as intended) I have no time for checking out its behaviour...
    $userBaskets->save();

    //set content type HTTP field  with the right value (we are going to use a JSON response)
    $this->getResponse()->setContentType('application/json');

    //Bypass completely the view layer and set the response code directly from this action.
    //In this way the user may know if the data were updated
    return $this->renderText(json_encode($uniqChecked));
  }
}
