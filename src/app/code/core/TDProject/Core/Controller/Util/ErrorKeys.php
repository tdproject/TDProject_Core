<?php

/**
 * TDProject_Core_Controller_Util_ErrorKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package     TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Controller_Util_ErrorKeys
{
	/**
	 * Private constructor for marking
	 * the class as utiltiy.
	 *
	 * @return void
	 */
	private final function __construct() { /* Class is a utility class */ }

	/**
	 * The key for a password.
	 * @var string
	 */
	const PASSWORD = "password";

	/**
	 * The key for a retyped password.
	 * @var string
	 */
	const PASSWORD_RETYPE = "passwordRetype";

    /**
     * The key for matching the passwords.
     * @var string
     */
    const PASSWORD_EQUAL = "passwordEqual";
	/**
	 * The key for the system error.
	 * @var string
	 */
	const SYSTEM_ERROR = "systemError";

	/**
	 * The key for a username.
	 * @var string
	 */
	const USERNAME = "username";

	/**
	 * The key for a email.
	 * @var string
	 */
	const EMAIL = "email";

	/**
     * The key for a userId.
     * @var string
     */
    const USER_ID = "userId";

	/**
	 * The key for the support email.
	 * @var string
	 */
	const EMAIL_SUPPORT = "emailSupport";

	/**
	 * The key for the message resource key.
	 * @var string
	 */
	const KEY = "key";

	/**
	 * The key for the message resource value.
	 * @var string
	 */
	const MESSAGE = "message";
}