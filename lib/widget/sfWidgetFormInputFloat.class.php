<?php

/**
 * sfWidgetFormInputFloat congigures float type HTML attribute (type="float" in input HTML field)
 *
 * @package    mobiads
 * @subpackage widget
 * @author     Gustavo Martin Morcuende
 * @version    
 */
class sfWidgetFormInputFloat extends sfWidgetFormInputText
{
	/**
 	 * Configures the current widget.
 	 *
 	 * @param array $options     An array of options
 	 * @param array $attributes  An array of default HTML attributes
 	 *
 	 * @see sfWidgetForm
 	 */

	protected function configure($options = array(), $attributes = array())
	{
 	    parent::configure($options, $attributes);
 	
 		$this->setOption('type', 'float');
 	}

}
