<?php

/**
 * TDProject_Core_Model_Homes_System_UserLocalHome
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'Zend/Acl.php';
require_once 'TechDivision/Collections/ArrayList.php';
require_once 'TDProject/Core/Model/Homes/UserLocalHome.php';
require_once 'TDProject/Core/Model/Entities/System/User.php';

/**
 * This class provides methods needed to
 * access the data from the database.
 *
 * @package epb
 * @subpackage homes
 * @author generator <core@techdivision.com>
 * @version $Revision: 1.3 $ $Date: 2008-03-04 14:58:01 $
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 */
class TDProject_Core_Model_Homes_System_UserLocalHome
    extends TDProject_Core_Model_Homes_UserLocalHome {

    /**
     * (non-PHPdoc)
     * @see TechDivision_Model_Interfaces_Entity::getEntityAlias()
     */
    public function getEntityAlias()
    {
        return 'TDProject_Core_Model_Entities_System_User';
    }
}