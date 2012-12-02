<?php

/**
 * WebServiceSigninForm
 *
 * @package    mobileadvertising
 * @subpackage form
 * @author     Gustavo Martin Morcuende
 * @version    
 */
class WebServiceSigninForm extends BasesfGuardFormSignin
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();

  }
}  
