<?php

/**
 * TDProject_Core_Controller_Login
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Application.php';
require_once 'TDProject/Core/Block/Login.php';
require_once 'TDProject/Core/Block/Dashboard.php';
require_once 'TDProject/Core/Controller/Abstract.php';
require_once 'TDProject/Core/Controller/Util/WebSessionKeys.php';

/**
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Controller_Login
    extends TDProject_Core_Controller_Abstract {

    /**
     * The ActionForward key for the login page.
     * @var string
     */
    const LOGIN = 'Login';

	/**
	 * The ActionForward key to the dashboard.
	 * @var string
	 */
	const DASHBOARD = 'Dashboard';

	/**
	 * This method is automatically invoked by the controller and implements the functionality
	 * for the user authentication.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function __default()
	{
	    // forward to the login page
    	return $this->_findForward(
    	    TDProject_Core_Controller_Login::LOGIN
    	);
	}

	/**
	 * This method prevents from adding the 'Action' suffix
	 * to the Controller methods before invoking them. This
	 * is necessary to exclude them from authorization.
	 *
	 * @param string $method The method to return the method name to invoke
	 * @return string The method name to invoke
	 */
    protected function _getMethodName($method)
    {
        return $method;
    }

	/**
	 * This method is automatically invoked by the controller and implements the functionality
	 * for the user authentication.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function logout()
	{
		// remove the system user from the Session
		$this->_getRequest()->getSession()->removeAttribute(
		    TDProject_Core_Controller_Util_WebSessionKeys::SYSTEM_USER
		);
		// set the ActionForward in the Context
		return $this->__default();
	}

	/**
	 * This method is automatically invoked by the controller and implements the
	 * functionality for the user authentication.
	 *
	 * @return TechDivision_Controller_Action_Forward Returns a ActionForward
	 */
	public function validate()
	{
		try {
			// validate the ActionForm with the login credentials
			$actionErrors = $this->_getActionForm()->validate();
			// check if errors was found
			if ($actionErrors->size() > 0) {
			    // save the errors
				$this->_saveActionErrors($actionErrors);
                // return to the login page
				return $this->__default();
			}
			// login and load the system user
			$systemUser = $this->_getDelegate()->login(
			    $this->_getActionForm()->getUsername(),
			    $this->_getActionForm()->getPassword()
			);
			// store the system user in the Session
			$this->_setSystemUser($systemUser);
			//get the user's locale from the database
			$locale = $systemUser->getUserLocale();
			//add the user's locale to the session
			$session = $this->_getRequest()->getSession();
			$session->setAttribute(TDProject_Application::LOCALE, $locale);
		} catch(TDProject_Core_Common_Exceptions_InvalidUsernameException $iue) {
			// log the exception
			$this->_getLogger()->error($iue->__toString());
			// create action errors container
			$errors = new TechDivision_Controller_Action_Errors();
			// add error to container
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::USERNAME,
			        $this->translate('username.invalid')
			    )
			);
			// save container in request
			$this->_saveActionErrors($errors);
			// return failure mapping
			return $this->_findForward(
                TDProject_Core_Controller_Login::LOGIN
			);
		} catch(TDProject_Core_Common_Exceptions_InsufficientRightsException $ire) {
			// log the exception
			$this->_getLogger()->error($ire->__toString());
            // create action errors container
            $errors = new TechDivision_Controller_Action_Errors();
            // add error to container
            $errors->addActionError(
                new TechDivision_Controller_Action_Error(
                    TDProject_Core_Controller_Util_ErrorKeys::PASSWORD,
                    $this->translate('insufficient.rights')
                )
            );
            // save container in request
            $this->_saveActionErrors($errors);
            // return failure mapping
			return $this->_findForward(
                TDProject_Core_Controller_Login::LOGIN
			);
		} catch(TDProject_Core_Common_Exceptions_InvalidPasswordException $ipe) {
			// log the exception
			$this->_getLogger()->error($ipe->__toString());
			// create action errors container
			$errors = new TechDivision_Controller_Action_Errors();
			// add error to container
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::PASSWORD,
			        $this->translate('password.invalid')
			    )
			);
			// save container in request
			$this->_saveActionErrors($errors);
			// return failure mapping
			return $this->_findForward(
                TDProject_Core_Controller_Login::LOGIN
			);
		} catch (Exception $e) {
			// log the exception
			$this->_getLogger()->error($e->__toString());
			// create action errors container
			$errors = new TechDivision_Controller_Action_Errors();
			// add error to container
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::SYSTEM_ERROR,
			        $e->__toString()
			    )
			);
			// save container in request
			$this->_saveActionErrors($errors);
			// set the ActionForward in the Context
			return $this->_findForward(
			    TDProject_Core_Controller_Util_GlobalForwardKeys::SYSTEM_ERROR
			);
		}
		// return the ActionForward to the start page of the protected area
		return $this->_findForward(
            TDProject_Core_Controller_Login::DASHBOARD
		);
	}
}