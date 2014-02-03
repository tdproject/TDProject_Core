<?php

/**
 * TDProject_Core_Controller_Form_LoginForm
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/String.php';
require_once 'TDProject/Core/Block/AbstractForm.php';

/**
 * This class implements the form functionality
 * for handling a login.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Block_Login_Form
    extends TDProject_Core_Block_AbstractForm {

    /**
     * The form key.
     * @var string
     */
    const FORM_KEY = 'loginForm';

	/**
	 * Form variable for the username.
	 * @var TechDivision_Lang_String
	 */
	protected $_username = null;

	/**
	 * Form variable for the password.
	 * @var TechDivision_Lang_String
	 */
	protected $_password = null;

	/**
	 * Getter method for variable username.
	 *
	 * @return TechDivision_Lang_String The username
	 */
	public function getUsername() {
		return $this->_username;
	}

	/**
	 * Setter method for variable username.
	 *
	 * @param string $string The username
	 * @return void
	 */
	public function setUsername($string) {
		$this->_username = new TechDivision_Lang_String($string);
	}

	/**
	 * Getter method for variable password.
	 *
	 * @return TechDivision_Lang_String The password
	 */
	public function getPassword() {
		return $this->_password;
	}

	/**
	 * Setter method for variable password.
	 *
	 * @param string $string The password
	 * @return void
	 */
	public function setPassword($string) {
		$this->_password = new TechDivision_Lang_String($string);
	}

	/**
	 * Resets all member variables to their
	 * default values.
	 *
	 * @return void
	 */
	function reset() {
		$this->_username = new TechDivision_Lang_String();
		$this->_password = new TechDivision_Lang_String();
	}

	/**
	 * This method checks if the values in the member variables
	 * holds valiid data. If not, a ActionErrors container will
	 * be initialized an for every incorrect value a ActionError
	 * object with the apropriate error message will be added.
	 *
	 * @return TechDivision_Controller_Action_Errors
	 * 		Returns a ActionErrors container with ActionError objects
	 */
	function validate() {
		// initialize the ActionErrors
		$errors = new TechDivision_Controller_Action_Errors();
		// check if a username was entered
		if ($this->_username->length() == 0) {
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::USERNAME,
			        $this->translate('username.none')
			    )
			);
		}
		// check if a password was entered
		if ($this->_password->length() == 0) {
			$errors->addActionError(
			    new TechDivision_Controller_Action_Error(
			        TDProject_Core_Controller_Util_ErrorKeys::PASSWORD,
			        $this->translate('password.none')
			    )
			);
		}
		// return the ActionErrors
		return $errors;
	}
}