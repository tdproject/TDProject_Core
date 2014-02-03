<?php

/**
 * TDProject_Core_Controller_User
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Controller/Abstract.php';
require_once 'TDProject/Core/Common/ValueObjects/System/UserValue.php';
require_once 'TDProject/Core/Common/ValueObjects/UserLightValue.php';
require_once 'TDProject/Core/Block/User/Overview.php';
require_once 'TDProject/Core/Block/User/View.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Markus Berwanger <m.berwanger@techdivision.com>
 */
class TDProject_Core_Controller_OwnOption
    extends TDProject_Core_Controller_Abstract {


	/**
	 * The key for the ActionForward to the user view template.
	 * @var string
	 */
	const OWN_OPTION_VIEW = "OwnOptionView";

	/**
     * Initializes the Action with the Context for the
     * actual request.
	 *
     * @param TechDivision_Controller_Interfaces_Context $context
     * 		The Context for the actual Request
     * @return void
	 */
	public function __construct(
        TechDivision_Controller_Interfaces_Context $context) {
        // call the parent method
        parent::__construct($context);
		 // initialize the default page title
		 $this->_setPageTitle(new TechDivision_Lang_String('TDProject, v2.0 - UsersOptions'));
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the page where the user can edit
	 * his own options.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function __defaultAction()
	{
		 try {
            // get the Id of the system user
            $userId = $this->_getSystemUser()->getUserId();
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getOwnUserViewData($userId)
            );
            // register the DTO in the Request
            $this->_getRequest()->setAttribute(
                TDProject_Core_Controller_Util_WebRequestKeys::VIEW_DATA,
                $dto
            );
        } catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_Errorkeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
        // return to the own option page
        return $this->_findForward(
            self::OWN_OPTION_VIEW
        );
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to save the passed user data.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function saveAction()
	{
		try {
		    // load the ActionForm
		    $actionForm = $this->_getActionForm();
		    // validate the ActionForm with the login credentials
            $actionErrors = $actionForm->validate();
            if (($errorsFound = $actionErrors->size()) > 0) {
                $this->_saveActionErrors($actionErrors);
                return $this->__defaultAction();
            }
			// save the user
			$systemUser = $this->_getDelegate()
			    ->updateOwnUser($actionForm->repopulate());
			// store the system user in the Session
			$this->_setSystemUser($systemUser);
			// create the affirmation message
	        $actionMessages = new TechDivision_Controller_Action_Messages();
            $actionMessages->addActionMessage(
                new TechDivision_Controller_Action_Message(
                    TDProject_Core_Controller_Util_MessageKeys::AFFIRMATION,
                    $this->translate('userUpdate.successfull')
                )
            );
            // save the ActionMessages in the request
            $this->_saveActionMessages($actionMessages);
        } catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
                    $e->__toString()
                )
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// return to the own option page
        return $this->__defaultAction();
	}

    /**
     * The user is not allowed to delete himself display an error to
     * inform about.
     * @return void
     */
	public function deleteAction()
	{
	    // create the information message
	    $actionMessages = new TechDivision_Controller_Action_Messages();
	    $actionMessages->addActionMessage(
    	    new TechDivision_Controller_Action_Message(
        	    TDProject_Core_Controller_Util_MessageKeys::INFORMATION,
        	    $this->translate('selfDeleteNotPossible')
        	)
	    );
	    // save the ActionMessages in the request
	    $this->_saveActionMessages($actionMessages);
	    // return to the own option page
        return $this->__defaultAction();
	}

	/**
	 * Tries to load the Block class specified as path parameter
	 * in the ActionForward. If a Block was found and the class
	 * can be instanciated, the Block was registered to the Request
	 * with the path as key.
	 *
	 * @param TechDivision_Controller_Action_Forward $actionForward
	 * 		The ActionForward to initialize the Block for
	 * @return void
	 */
	protected function _getBlock(
	    TechDivision_Controller_Action_Forward $actionForward) {
	    // check if the class required to initialize the Block is included
	    if (!class_exists($path = $actionForward->getPath())) {
	        return;
	    }
	    // initialize the page and add the Block
	    $page = new TDProject_Core_Block_Page($this->getContext());
	    $page->setPageTitle($this->_getPageTitle());
	    $page->addBlock($this->getContext()->getActionForm());
	    // register the Block in the Request
	    $this->_getRequest()->setAttribute($path, $page);
	}
}