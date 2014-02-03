<?php

/**
 * TDProject_Core_Observer_Controller_Logging_Json
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category    TDProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Observer_Controller_Logging_Json
	extends TechDivision_Lang_Object
{
    
    /**
     * Dummy constructor to avoid object factory
     * initialization problems.
     * 
     * @return void
     */
    public function __construct()
    {
    	// dummy constructor	
    }

	/**
	 * Dummy implementation for observer test.
	 *
	 * @param TDProject_Interfaces_Event_Observer_Action $observer
	 * 		The observer instance
	 */
	public function postDispatchLoggingJson(
		TDProject_Interfaces_Event_Observer_Action $observer)
	{
	}
}