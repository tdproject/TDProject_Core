<?php

/**
 * TDProject_Core_Controller_Util_WebSessionKeys
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
class TDProject_Core_Controller_Util_WebSessionKeys
{

	/**
	 * Private constructor for marking
	 * the class as utiltiy.
	 *
	 * @return void
	 */
	private final function __construct() { /* Class is a utility class */ }

	/**
	 * The Session key with the user id.
	 * @var string
	 */
	const USER_ID = "userId";

	/**
	 * The Session key for storing the system user.
	 * @var string
	 */
	const SYSTEM_USER = "systemUser";
	
	/**
     * The Session key for storing the dealer.
     * @var string
     */
    const DEALER = "dealer";
    
    /**
     * The Session key for storing the dealerId.
     * @var string
     */
    const DEALER_ID = "dealer_id";

    /**
     * The session key for the ACL.
     * @var string
     */
    const ACL = 'acl';
}