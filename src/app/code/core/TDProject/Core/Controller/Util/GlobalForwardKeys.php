<?php

/**
 * TDProject_Core_Controller_Util_GlobalForwardKeys
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
class TDProject_Core_Controller_Util_GlobalForwardKeys
{

	/**
	 * Private constructor for marking
	 * the class as utiltiy.
	 *
	 * @return void
	 */
	private final function __construct() { /* Class is a utility class */ }

	/**
	 * The ActionFoward key for handling a system error.
	 * @var string
	 */
	const SYSTEM_ERROR = "SystemError";

	/**
	 * The ActionFoward key for handling a system login.
	 * @var string
	 */
	const SYSTEM_LOGIN = "SystemLogin";
	
	/**
	 * The ActionForwad key for rendering the System messages block only.
	 * @var string
	 */
	const SYSTEM_MESSAGES = "SystemMessages";
	
	/**
	 * The ActionForwad key for the dashboard.
	 * @var string
	 */
	const DASHBOARD = "Dashboard";
}

