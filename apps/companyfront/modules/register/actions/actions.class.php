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


    $this->form = new CompaniesRegisterForm();

    if ($request->isMethod('post'))
    {
      $captcha = array('recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
                       'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
                      );

      $this->form->bind(array_merge($request->getParameter($this->form->getName()), array('captcha' => $captcha)), $request->getFiles($this->form->getName()));
      if ($this->form->isValid())
      {
        $user = $this->form->save();
        $user->addPermissionByName('companies');
        $this->getUser()->signIn($user);

        $this->redirect('@homepage');
      }
    }
  }
}
