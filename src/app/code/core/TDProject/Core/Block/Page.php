<?php

/**
 * TDProject_Core_Block_Page
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TDProject/Core/Block/Page/Head.php';
require_once 'TDProject/Core/Block/Page/Footer.php';
require_once 'TDProject/Core/Block/Navigation.php';
require_once 'TDProject/Core/Block/Action.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Page extends TDProject_Core_Block_Abstract 
{

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context)
    {
        // set the internal name
        $this->_setBlockName('page');
        // set the template name
        $this->_setTemplate('www/design/core/templates/page.phtml');
        // call the parent constructor
        parent::__construct($context);
    }

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout()
    {
        // add the <head> block
        $this->addBlock(new TDProject_Core_Block_Page_Head($this));
        // add the navigation block
        $this->addBlock(new TDProject_Core_Block_Navigation($this->getContext()));
        // add the Block with the ActionMessages and ActionErrors
	    $this->addBlock(new TDProject_Core_Block_Action($this->getContext()));
        // add the page footer
        $this->addBlock(new TDProject_Core_Block_Page_Footer($this));
        // call the parent method
        return parent::prepareLayout();
    }

    /**
     * Sets the page title.
     *
     * @param TechDivision_Lang_String $pageTitle
     * 		The page title to set
     */
    public function setPageTitle(TechDivision_Lang_String $pageTitle)
    {
    	$this->_setBlockTitle($pageTitle);
    }

    /**
     * Returns the login URL.
     *
	 * @return string The URL to the login Action
	 * @see TDProject/Application#getUrl(array $params = array())
     */
    public function getLoginUrl()
    {
        // the URL params to append
        $params = array(
            'path' => '/login'
        );
        // returns the URL
        return $this->getUrl($params);
    }

    /**
     * Returns the logout URL.
     *
	 * @return string The URL to the logout Action
	 * @see TDProject/Application#getUrl(array $params = array())
     */
    public function getLogoutUrl()
    {
        // the URL params to append
        $params = array(
            'path' => '/login',
            'method' => 'logout'
        );
        // returns the URL
        return $this->getUrl($params);
    }

    /**
     * Returns a CSS style class name for the
     * actual page.
     *
     * @return string The CSS style class name for the actual page
     */
    public function getStyle()
    {
        // load the path from the Request
        $path = $this->getRequest()->getParameter(
            TechDivision_Controller_Action_Controller::ACTION_PATH,
            FILTER_SANITIZE_STRING
        );
		// create a CSS styled class name
		return implode('-', explode('/', substr($path, 1, strlen($path))));
    }

    /**
     * Returns the URL to switch the language between
     * de_DE and en_US.
     *
     * @return string The requested URL
     */
    public function getLanguageUrl()
    {
        // extract the request parameters
        parse_str($this->getRequest()->getQueryString(), $params);
        // load the default system locale
        $defaultLocale = $this->getApp()->getDefaultLocale();
        // initialize the new locale with the default locale
        $newLocale = $defaultLocale->__toString();
        // if the default is active, set the GERMANY
        if ($this->getSystemLocale()->equals($defaultLocale)) {
            $newLocale = TechDivision_Util_SystemLocale::GERMANY;
        }
        // replace/append the one from the Request
        $params[TDProject_Application::LOCALE] = $newLocale;
        // return the URL to switch the system locale
        return $this->getUrl($params);
    }
    
    /**
     * Returns the String representation of the current year (4-digit format).
     * @string string year
     */
    public function getCurrentYear()
    {
        return date('Y');
    }
}