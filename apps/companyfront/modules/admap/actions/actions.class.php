<?php

/**
 * ad actions.
 *
 * @package    mobiads
 * @subpackage ad
 * @author     Gustavo Martin Morcuende
 * @version
 */
class admapActions extends sfActions
{
  public function executeAdmap(sfWebRequest $request)
  {
    $this->zoom = 8;
    $this->latitude = $request->getParameter('latitude');
    if ($this->latitude == "")
    {
        $this->latitude = 0;
        $this->zoom = 1;
    }
    $this->longitude = $request->getParameter('longitude');
    if ($this->longitude == "")
    {
        $this->longitude = 0;
        $this->zoom = 1;
    }
  }

  public function executeOfficemap(sfWebRequest $request)
  { 
    $this->zoom = 8;
    $this->latitude = $request->getParameter('latitude');
    if ($this->latitude == "")
    {
        $this->latitude = 0;
        $this->zoom = 1;
    }
    $this->longitude = $request->getParameter('longitude');
    if ($this->longitude == "")
    {
        $this->longitude = 0;
        $this->zoom = 1;
    }
  }
}
