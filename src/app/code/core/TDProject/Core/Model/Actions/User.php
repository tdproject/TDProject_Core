<?php

/**
 * TDProject_Core_Model_Actions_User
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
class TDProject_Core_Model_Actions_User
    extends TDProject_Core_Model_Actions_Abstract {

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Actions_User($container);
    }
    
    /**
     * Save/Update the user with the given values.
     * @param TDProject_Core_Common_ValueObjects_UserLightValue $lvo
     */
    public function saveUser(
        TDProject_Core_Common_ValueObjects_UserLightValue $lvo)
    {
        // look up user id
        $userId = $lvo->getUserId();
        // store the user
        if ($userId->equals(new TechDivision_Lang_Integer(0))) {
            // create a new user, check for existing username
            $users = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
                ->findAllByUsername(
                    $username = $lvo->getUsername()
                );
            // check of already a user with the requested username exists
            if ($users->size() > 0) {
                throw new TDProject_Core_Common_Exceptions_UsernameNotUniqueException(
            		'Username ' . $username . ' is not unique'
                );
            }
            // create a new user
            $user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
                ->epbCreate();
            // set the data
            $user->setUsername($lvo->getUsername());
            $user->setRate($lvo->getRate());
            $user->setUserLocale($lvo->getUserLocale());
            $user->setContractedHours($lvo->getContractedHours());
            $user->setEmail($lvo->getEmail());
            $user->setEnabled($lvo->getEnabled());
            // clone the username to generate a password
            $username = clone $user->getUsername();
            // set and encode the password
            $user->setPassword($username->md5());
            $userId = $user->create();
            // create a new role for the the user
            $role = TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())
                ->epbCreate();
            $role->setUserIdFk($userId);
            $role->setRoleIdFk($lvo->getDefaultRole()->getRoleId());
            $role->setName($user->getUsername());
            $role->create();
        } else {
            // update the user
            $user = TDProject_Core_Model_Utils_UserUtil::getHome($this->getContainer())
                ->findByPrimaryKey($userId);
            $user->setUsername($lvo->getUsername());
            $user->setUserLocale($lvo->getUserLocale());
            $user->setRate($lvo->getRate());
            $user->setContractedHours($lvo->getContractedHours());
            $user->setEmail($lvo->getEmail());
            $user->setEnabled($lvo->getEnabled());
            $user->update();
            // load and update the user's roles
            $roles = TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())
                ->findAllByUserIdFk($userId);
            foreach ($roles as $role) {
                $role->setRoleIdFk($lvo->getDefaultRole()->getRoleId());
                $role->update();
            }
        }
        return $userId;
    }
}