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
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Controller_User
    extends TDProject_Core_Controller_Abstract {

	/**
	 * The key for the ActionForward to the user overview template.
	 * @var string
	 */
	const USER_OVERVIEW = "UserOverview";

	/**
	 * The key for the ActionForward to the user view template.
	 * @var string
	 */
	const USER_VIEW = "UserView";

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
		 $this->_setPageTitle(new TechDivision_Lang_String('TDProject, v2.0 - Users'));
	}

	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load a list with with all registered users.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function __defaultAction()
	{
		try {
			// replace the default ActionForm
			$this->getContext()->setActionForm(
				new TDProject_Core_Block_User_Overview($this->getContext())
			);
            // load and register the user overview data
            $this->_getRequest()->setAttribute(
            	TDProject_Core_Controller_Util_WebRequestKeys::OVERVIEW_DATA,
            	$this->_getDelegate()->getUserOverviewData()
            );
		} catch(Exception $e) {
			// create and add and save the error
			$errors = new TechDivision_Controller_Action_Errors();
			$errors->addActionError(new TechDivision_Controller_Action_Error(
                TDProject_Core_Controller_Util_Errorkeys::SYSTEM_ERROR, $e->__toString())
            );
			// adding the errors container to the Request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// go to the standard page
		return $this->_findForward(
		    TDProject_Core_Controller_User::USER_OVERVIEW
		);
	}


	/**
	 * This method is automatically invoked by the controller and implements
	 * the functionality to load the user data with the id passed in the
	 * Request for editing it.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	function editAction()
	{
        try {
            // try to load the user ID from the Request
            if (($userId = $this->_getRequest()->getAttribute(
                TDProject_Core_Controller_Util_WebRequestKeys::USER_ID)) == null) {
                $userId = $this->_getRequest()->getParameter(
                    TDProject_Core_Controller_Util_WebRequestKeys::USER_ID,
                    FILTER_VALIDATE_INT
                );
            }
            // check if a user ID was found
            if (!empty($userId)) {
                $userId = TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($userId)
                );
            } else {
                // if not, use the ID of the system user
                $userId = $this->_getSystemUser()->getUserId();
            }
            // initialize the ActionForm with the data from the DTO
            $this->_getActionForm()->populate(
                $dto = $this->_getDelegate()->getUserViewData($userId)
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
        // return to the user detail page
        return $this->_findForward(
            TDProject_Core_Controller_User::USER_VIEW
        );
	}

   /**
     * This method is automatically invoked by the controller and implements
     * the functionality to create a new user.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    function createAction()
    {
        try {
            //get the UserViewData
            $userViewData = $this->_getDelegate()->getUserViewData();
           
            // set the available roles
            $this->_getActionForm()->setRoles(
                $userViewData->getRoles()
            );
            $this->_getActionForm()->setLocales(
                $userViewData->getLocales()
            );
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
        // return to the user detail page
        return $this->_findForward(TDProject_Core_Controller_User::USER_VIEW);
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
                return $this->createAction();
            }
			// save the user
			$userId = $this->_getDelegate()
			    ->saveUser($actionForm->repopulate());
			// store the id of the user in the Request
			$this->_getRequest()->setAttribute(
                TDProject_Core_Controller_Util_WebRequestKeys::USER_ID,
                $userId->intValue()
            );
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
		} catch(TDProject_Core_Common_Exceptions_UsernameNotUniqueException $unue) {
            // create action errors container
            $errors = new TechDivision_Controller_Action_Errors();
            // add error to container
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::USERNAME,
                    $this->translate('username.not.unique')
                )
            );
            // save container in request
            $this->_saveActionErrors($errors);
            // return failure mapping
            return $this->create();
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
		// return to the user detail page
        return $this->editAction();
	}

	/**
     * This method is automatically invoked by the controller and implements
     * the functionality to delete the passed user.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    function deleteAction() {
        try {
            // load the user ID from the request
        	$userId = $this->_getRequest()->getParameter(
                TDProject_Core_Controller_Util_WebRequestKeys::USER_ID,
                FILTER_VALIDATE_INT
            );
            // delete the user
            $this->_getDelegate()->deleteUser(
                TechDivision_Lang_Integer::valueOf(
                    new TechDivision_Lang_String($userId)
                )
            );
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
        // return to the user overview page
        return $this->__defaultAction();
    }

    /**
     * This method is automatically invoked by the controller and implements
     * the functionality to release or lock the passed user.
     *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
     */
    function changeUserStatusAction() {
        try {
            // get the userId from the request
            $userId = TechDivision_Lang_Integer::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                        TDProject_Core_Controller_Util_WebRequestKeys::USER_ID
                    )
                )
            );
            // get the status from the request
            $active = TechDivision_Lang_Boolean::valueOf(
                new TechDivision_Lang_String(
                    $this->_getRequest()->getParameter(
                        TDProject_Core_Controller_Util_WebRequestKeys::ENABLED
                    )
                )
            );
            // change the status of a user
            $this->_getDelegate()->changeUserStatus($userId, $active);
        } catch(TDProject_Core_Common_Exceptions_InValidUseridException $iue) {
            // write a log message
            $this->_getLogger()->error($ire->__toString());
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_LOGIN
			);
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
        // go to the editing page
        return $this->editAction();
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