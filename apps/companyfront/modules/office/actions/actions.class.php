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
    $this->offices = Doctrine_Core::getTable('Office')
      ->createQuery('a')
      ->execute();
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

    $this->form = new OfficeForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id'))), sprintf('Object office does not exist (%s).', $request->getParameter('id')));
    $this->form = new OfficeForm($office);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id'))), sprintf('Object office does not exist (%s).', $request->getParameter('id')));
    $this->form = new OfficeForm($office);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($office = Doctrine_Core::getTable('Office')->find(array($request->getParameter('id'))), sprintf('Object office does not exist (%s).', $request->getParameter('id')));
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
