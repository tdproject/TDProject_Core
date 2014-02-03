<?php

/**
 * TDProject_Core_Common_Email_Abstract
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TDProject/Core/Interfaces/Email.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
abstract class TDProject_Core_Common_Email_Abstract
	extends TechDivision_Lang_Object
	implements TDProject_Core_Interfaces_Email {
		
	/**
	 * The template for the HTML body.
	 * @var string 
	 */
	protected $_templateHtml = '';
	
	/**
	 * The template for the text body.
	 * @var string
	 */
	protected $_templateText = '';
	
	/**
	 * Sets the HTML template.
	 * 
	 * @param string $templateHtml
	 * 		The HTML template
	 * @return TDProject_Core_Interfaces_Email
	 * 		The instance itself
	 */
	public function setTemplateHtml($templateHtml) 
	{
		$this->_templateHtml = $templateHtml;
		return $this;
	}
	
	/**
	 * Sets the text template.
	 * 
	 * @param string $templateText
	 * 		The text template
	 * @return TDProject_Core_Interfaces_Email
	 * 		The instance itself
	 */
	public function setTemplateText($templateText)
	{
		$this->_templateText = $templateText;
		return $this;
	}
	
	/**
	 * Loads the passed template with the PHP function
	 * require and returns the content.
	 * 
	 * @param string $template
	 * 		The name of the template to fetch
	 * @return string The fetched content
	 * @link http://de2.php.net/manual/de/function.require.php
	 */
	public function fetch($template)
	{
		// start content buffering 
		ob_start();
		// include the template
    	require $template;
		// load the content from the buffer
		$content = ob_get_contents();
		// clean the buffer
		ob_end_clean();
		// return the templates fetched content
		return $content;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Email::getTemplateHtml()
	 */
	public function getTemplateHtml()
	{
		return $this->_templateHtml;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Email::getTemplateText()
	 */
	public function getTemplateText()
	{
		return $this->_templateText;
	}
    
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Email::getBodyHtml()
	 */
    public function getBodyHtml()
    {
    	return $this->fetch($this->getTemplateHtml());
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Email::getBodyText()
     */
    public function getBodyText()
    {
    	return $this->fetch($this->getTemplateText());
    }
}