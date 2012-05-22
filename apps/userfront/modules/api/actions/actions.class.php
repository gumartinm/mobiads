<?php

/**
 * api actions.
 *
 * @package    mobileadvertising
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

 /**
  * RESTful Web Service: receiving latitude and longitude, it sends a response with the found ads on thoses coordinates.
  * 
  * We will try to reduce as much as we can the number of methods and queries. While the tables in the data base do not have many rows 
  * we will try to make the queries directly in the data base. When the tables get bigger than now probably we are going to need
  * a solution based on queries to data base and php code. Right now and with this size, the fastest solution (IMHO) is to make the queries
  * directly on the data base.
  *
  * TODO: Take measures about the performance using queries directly to the data base and using Doctrine Objects with PHP
  *       Choose this or the other one solution. I got no time to make this profiling before. But to be serious I should do it.  
  *       Now I am using queries directly to the data base because I am making the supposition that this is the best to achieve high performance. 
  *
  * TODO: C-programmed dedicated server to make this stuff without using PHP should be the best to achieve the max performance.
  * 
  * @param sfRequest $request A request object
  */
  public function executeGetadsbygps(sfWebRequest $request)
  {
	//With RESTFUL is allowed to use cookies to get authentication (user / password)
	$this->ads = AdTable::getInstance()->getAdsByGPSandUserId($this->getRoute()->getParameters(), $this->getUser()->getGuardUser()->getId());
  	if (!$this->ads)
	{
		//If there are not results.
		//In production replace this line by a die command (trying to stop wasting TCP bandwidth)
		throw new sfError404Exception(sprintf('
			There are not offices with GPS coordinates: longitude "%s" and 
			latitude "%s".', $request->getParameter('longitude'), $request->getParameter('latitude')));
		//die;
	}
  }

 /**
  * RESTful Web Service: authentication by username/email and password.
  * 
  * This service checks the username and password. It must response with OK or NOK and the user's cookie
  * See in this module the config/security.yml file. This action must not be executed under security conditions
  *
  * @param sfRequest $request A request object
  */
  public function executeLoginauth(sfWebRequest $request)
  {
    //If everything goes alright the mobile will receive HTTP 200 OK, otherwise HTTP 401 Unauthorized or 400 Bad Request
    $this->getResponse()->setStatusCode(401);

    if ($this->getUser()->isAuthenticated())
    {
      //If the mobile is authenticated, why the heck it is reaching this code? It must log in just once, when launching the application
      $this->getResponse()->setStatusCode(400);
    }
    else
    {
	  $form = new WebServiceSigninForm();
      //TODO: JSON instead of signin array as container to send the data from the mobile to this Web Service (I have no time right now...)
      $form->bind($request->getParameter('signin'));
      if ($form->isValid())
      {
        $values = $form->getValues();
        $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);
        $this->getResponse()->setStatusCode(200);
      }
    }

    //Returning from this function with the StatusCode with its right value

  }	

 /** 
  * RESTful Web Service: log out from the web application
  *
  * This service checks the cookie sent by the user. If the user is authenticated it removes his/her permissions.
  * See in this module the config/security.yml file. This action must not be executed under security conditions
  *
  * @param sfRequest $request A request object
  */
  public function executeLogoutauth($request)
  {
    //If everything goes alright the mobile will receive HTTP 200 OK, otherwise HTTP 500 Internal Server Error
    $this->getResponse()->setStatusCode(500);
 
    $this->getUser()->signOut();
 
    $this->getResponse()->setStatusCode(200);
  }
}
