<?php

/**
 * TDProject_Core_Model_Assembler_Role
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
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Assembler_Role
    extends TDProject_Core_Model_Assembler_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Assembler_Role($container);
    }

    /**
     * Returns an ArrayList with all roles
     * assembled as LVO's.
     *
     * @return TechDivision_Collections_ArrayList
     * 		The requested role LVO's
     */
    public function getRoleLightValues()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the roles
        $roles = TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())
            ->findAllSystemRoles();
        // assemble the roles
        foreach ($roles as $role) {
            $list->add($role->getLightValue());
        }
        // return the ArrayList with the RoleLightValues
        return $list;
    }

    /**
     * Returns an ArrayList with all roles
     * assembled as DTO's and prepared for
     * usage as select options.
     *
     * @return TechDivision_Collections_ArrayList
     * 		The requested role DTO's
     */
    public function getRoleOverviewData()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the roles
        $roles = TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())
            ->findAllSystemRoles();
        // assemble the roles
        foreach ($roles as $role) {
            $list->add(
                new TDProject_Core_Common_ValueObjects_RoleOverviewData(
                    $role->getLightValue()
                )
            );
        }
        // return the ArrayList with the RoleLightValues
        return $list;
    }

    /**
     * Returns the user's default role, assembled as ACL Role.
     *
     * @param TechDivision_Lang_Integer $userId
     * @return TDProject_Core_Common_ValueObjects_RoleOverviewData
     * 		The assembled role
     */
    public function getAclRole(TechDivision_Lang_Integer $userId)
    {
        // load the user
        $user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
        	->findByPrimaryKey($userId);
        // load and return the user's first role
    	foreach ($user->getUserRoles() as $userRole) {
    	    return new TDProject_Core_Common_ValueObjects_RoleOverviewData(
    	        $userRole
    	    );
    	}
    }
}