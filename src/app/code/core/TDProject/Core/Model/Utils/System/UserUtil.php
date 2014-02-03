<?php

/**
 * TDProject_Core_Model_Utils_System_UserUtil
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
 * @subpackage	Model
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Utils_System_UserUtil {

    /**
     * Holds the home of the user entity.
     * @var UserHome
     */
    protected static $_home = null;
	
	/**
	 * Returns the home of the Assertion entity
	 *
	 * @param TechDivision_Model_Interfaces_Container $container The container instance
	 * @return AssertionHome Holds the home of the Assertion entity
	 */
	public function getHome(TechDivision_Model_Interfaces_Container $container)
    {
        if (TDProject_Core_Model_Utils_System_UserUtil::$_home == null) {
            TDProject_Core_Model_Utils_System_UserUtil::$_home = $container->newInstance('TDProject_Core_Model_Homes_System_UserLocalHome', array($container));
        }
        return TDProject_Core_Model_Utils_System_UserUtil::$_home;
    }
}