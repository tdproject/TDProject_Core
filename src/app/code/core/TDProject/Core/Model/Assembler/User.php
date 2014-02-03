<?php

/**
 * TDProject_Core_Model_Assembler_User
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
class TDProject_Core_Model_Assembler_User
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
        return new TDProject_Core_Model_Assembler_User($container);
    }

    /**
     * Returns a DTO initialized with the data of the user
     * with the passed ID.
     *
     * @param TechDivision_Lang_Integer $userId
     * 		The ID of the user the DTO has to be initialized for
     * @return TDProject_Core_Common_ValueObjects_UserViewData
     * 		The initialized DTO
     */
    public function getUserViewData(TechDivision_Lang_Integer $userId = null) {
    	// check if a user id was passed
    	if(!empty($userId)) { // if yes, load the user
    		$user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
    			->findByPrimaryKey($userId);
    	} else {
        	// if not, initialize a new channel
        	$user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
        		->epbCreate();
    	}
   		// initialize the DTO and add the available roles
  		$dto = new TDProject_Core_Common_ValueObjects_UserViewData(
  		    $user,
  		    $this->getUserDefaultRole($user)
  		);
    	$dto->setRoles(
    		TDProject_Core_Model_Assembler_Role::create($this->getContainer())
    			->getRoleOverviewData()
    	);
    	$dto->setLocales(
    	    TDProject_Core_Model_Assembler_Resource::create($this->getContainer())
    	        ->getLocaleOverviewData()
    	);

    	// return the initialized DTO
    	return $dto;
    }

    /**
     * Returns a DTO initialized with the data of the user
     * with the passed ID.
     *
     * @param TechDivision_Lang_Integer $userId
     * 		The ID of the user the DTO has to be initialized for
     * @return TDProject_Core_Common_ValueObjects_UserViewData
     * 		The initialized DTO
     */
    public function getOwnUserViewData(TechDivision_Lang_Integer $userId)
    {
        // load the system user
		$systemUser = TDProject_Core_Model_Utils_System_UserUtil::getHome($this->getContainer())
			->findByPrimaryKey($userId);
   		// initialize the DTO
  		$dto = new TDProject_Core_Common_ValueObjects_System_UserValue(
  		    $systemUser
  		);
  		// set the available locales
    	$dto->setLocales(
    	    TDProject_Core_Model_Assembler_Resource::create($this->getContainer())
    	        ->getLocaleOverviewData()
    	);
    	// return the initialized DTO
    	return $dto;
    }

    /**
     * Returns an ArrayList with all users
     * assembled as LVO's.
     *
     * @return TechDivision_Collections_ArrayList
     * 		The requested user LVO's
     */
    public function getUserLightValues()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the users
        $users = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
            ->findAll();
        // assemble the users
        foreach ($users as $user) {
            $list->add($user->getLightValue());
        }
        // return the ArrayList with the UserLightValues
        return $list;
    }

    /**
     * Returns an ArrayList with all users
     * assembled as DTO's.
     *
     * @return TechDivision_Collections_ArrayList
     * 		The requested user DTO's
     */
    public function getUserOverviewData()
    {
        // initialize a new ArrayList
        $list = new TechDivision_Collections_ArrayList();
        // load the users
        $users = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
        	->findAll();
        // assemble the users
        foreach ($users as $user) {
        	// load the user's roles
        	$roles = TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())
        		->findAllByUserIdFk($user->getUserId());
        	// assemble the DTO
        	$dto = new TDProject_Core_Common_ValueObjects_UserOverviewData(
        		$user->getLightValue(),
        		$this->getUserDefaultRole($user)
        	);
        	// add the DTO to the ArrayList
            $list->add($dto);
        }
        // return the ArrayList with the UserOverviewData
        return $list;
    }

    /**
     * As a user can have more than one role, this method returns the users
     * first role, the default one.
	 *
     * @param TDProject_Core_Model_Entities_User $user
     * 		The user to return the default role for
     * @return TDProject_Core_Common_ValueObjects_RoleLightValue
     * 		The user's default role
     */
    public function getUserDefaultRole(
        TDProject_Core_Model_Entities_User $user) {
        // load and return the user's first role
    	foreach ($user->getUserRoles() as $userRole) {
    	    return $userRole->getParent()->getLightValue();
    	}
    	// return an empty LVO
        return TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())->epbCreate();
    }
}