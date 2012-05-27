<?php

/**
 * api actions.
 *
 * @package    mobileadvertising
 * @subpackage api
 * @author     Gustavo Martin Morcuende
 * @version
 */
class registerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if ($this->getUser()->isAuthenticated())
    {
      $this->getUser()->setFlash('notice', 'You are already registered and signed in!');
      $this->redirect('@homepage');
    }


    $this->form = new UsersRegisterForm();

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $user = $this->form->save();
        $user->addPermissionByName('users');
        $this->getUser()->signIn($user);

        $this->redirect('@homepage');
      }
    }
  }
}
