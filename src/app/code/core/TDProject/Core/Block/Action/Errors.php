<?php

/**
 * TDProject_Core_Block_Action_Errors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Abstract.php';
require_once 'TechDivision/Controller/Action/Errors.php';

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Block_Action_Errors
    extends TDProject_Core_Block_Abstract {

    /**
     * Show block as jquery dialog if flag is true
     * @var boolean
     */
    protected $_dialog = true;

    /**
     * Initialize the block with the
     * apropriate template and name.
     *
     * @return void
     */
    public function __construct(
        TechDivision_Controller_Interfaces_Context $context,
        $dialog = true) {
        // set the internal name
        $this->_setBlockName('errors');
        // set the template name
        $this->_setTemplate('www/design/core/templates/action/errors.phtml');
        // set dialog mode
        $this->_setDialog($dialog);
        // call the parent constructor
        parent::__construct($context);
    }

    /**
     * Returns the ActionMessages container initialized
     * in the Controller or the ActionForm.
     *
     * @return TechDivision_Controller_Action_Messages
     * 		The container with the error messages
     */
    public function getErrors()
    {
        // initialize the container for the errors
        $errors = new TechDivision_Controller_Action_Errors();
    	// try to load the errors from the Request
        $requestErrors = $this->getRequest()
            ->getAttribute(
                TechDivision_Controller_Action_Errors::ACTION_ERRORS
            );
        // add the errors from the Request
        if (!empty($requestErrors)) {
        	foreach ($requestErrors as $error) {
        		$errors->addActionError($error);
        	}
        }
        // try to load the errors from the Session
        $sessionErrors = $this->getRequest()
        	->getSession()
        	->getAttribute(
        	    TechDivision_Controller_Action_Errors::ACTION_ERRORS
        	);
      	// remove the errors from the Session
        $this->getRequest()
        	->getSession()
        	->removeAttribute(
        	    TechDivision_Controller_Action_Errors::ACTION_ERRORS
        	);
        // add the errors from the Session
        if (!empty($sessionErrors)) {
        	foreach ($sessionErrors as $error) {
        		$errors->addActionError($error);
        	}
        }
        // return the errors
        return $errors;
    }

    /**
     * Set dialog flag if this block should be shown as a jQuery dialog
     * after the page rendering is finished.
     *
     * @param boolean $flag
     * @return TDProject_Core_Block_Action_Errors
     */
    protected function _setDialog($flag)
    {
    	$this->_dialog = $flag;
    	return $this;
    }

    /**
     * Gets the flag if this block should be shown as a jQuery dialog
     * after the page rendering is finished.
     *
     * @return boolean
     */
    public function isDialog()
    {
    	return $this->_dialog;
    }
}