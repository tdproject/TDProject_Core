<?php

/**
 * TDProject_Core_Model_Collections_Test
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Abstract implementation of a Collection for entities that supports caching.
 *
 * @category   	TDProject
 * @package     TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Collections_Test
	extends TDProject_Core_Model_Collections_Abstract
{

    public function getItemType()
    {
    	return 'TDProject_Core_Model_Entities_User';
    }
}