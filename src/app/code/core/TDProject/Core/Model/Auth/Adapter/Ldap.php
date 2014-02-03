<?php

/**
 * TDProject_Core_Model_Auth_Adapter_Ldap
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'Zend/Auth/Adapter/Ldap.php';
require_once 'Zend/Auth/Adapter/Exception.php';

/**
 * Zend_Auth Adapter for LDAP authentication 
 * against the LDAP repository defined in the 
 * project configuration.
 * 
 * @package Model
 * @author Tim Wagner <tw@techdivision.com>
 * @version $Revision: 1.1 $ $Date: 2007-10-25 16:09:14 $
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 */
class TDProject_Core_Model_Auth_Adapter_Ldap
    extends Zend_Auth_Adapter_Ldap {
    
    /**
     * The container instance.
     * @var TechDivision_Model_Interfaces_Container
     */
    protected $_container = null;
    
    /**
     * Sets the container instance.
     * 
     * @param TechDivision_Model_Interfaces_Container $container
     *     The container instance
     * @return TDProject_Core_Model_Auth_Adapter_Database The instance itself
     */
    public function setContainer(TechDivision_Model_Interfaces_Container $container)
    {
        $this->_container = $container;
        return $this;
    }
    
    /**
     * Returns the container instance.
     * 
     * @return TechDivision_Model_Interfaces_Container
     *     The container instance
     */
    public function getContainer()
    {
        return $this->_container;
    }
    
    /**
     * (non-PHPdoc)
     * @see Zend/Auth/Adapter/Zend_Auth_Adapter_Ldap::authenticate()
     */
    public function authenticate()
    {
        try {
            // try LDAP authentication first
            $result = parent::authenticate();
            // if LDAP authentication was successfull, sync user data
            if ($result->getCode() === Zend_Auth_Result::SUCCESS) {
                // load username and password
                $username = new TechDivision_Lang_String($this->getUsername());
                $password = new TechDivision_Lang_String($this->getPassword());
                // load the user by it's username
                $users = TDProject_Core_Model_Utils_System_UserUtil::getHome($this->getContainer())
                    ->findAllByUsername($username);
                // check if exactly one user was found
                if ($users->size() === 1) {
                	// load the user
                	$iter = $users->getIterator();
                    // set the data and update the user
                    $user = $iter->current();
                    $user->setLdapSynced(new TechDivision_Lang_Boolean(true));
                    $user->setSyncedAt(new TechDivision_Lang_Integer(time()));
                    $user->setPassword($password->md5());
                    $user->update();
                }
                // if no user was found, create a new one
                if ($users->size() === 0) {
                    // initialize and create a new user
                    $user = TDProject_Core_Model_Utils_System_UserUtil::getHome($this->getContainer())
                        ->epbCreate();
                    // initialize the user
                    $user->setUsername($username);
                    $user->setEmail(
                        new TechDivision_Lang_String(
                            $result->getIdentity()
                        )
                    );
                    $user->setUserLocale(TechDivision_Util_SystemLocale::getDefault()->toString());
                    $user->setEnabled(new TechDivision_Lang_Boolean(true));
                    $user->setRate(new TechDivision_Lang_Integer(0));
                    $user->setLdapSynced(new TechDivision_Lang_Boolean(true));
                    $user->setSyncedAt(new TechDivision_Lang_Integer(time()));
                    // initialize a default role
                    $defaultRole = TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())
                    	->epbCreate();
                    $defaultRole->setName($user->getUsername());
                    $defaultRole->setRoleId(new TechDivision_Lang_Integer(2));
                    // create a new DTO for storing the user
                    $dto = new TDProject_Core_Common_ValueObjects_UserOverviewData(
                    	$user,
                    	$defaultRole
                    );
                    // save the user and set the ID
                    $user->setUserId(
	                    TDProject_Core_Model_Actions_User::create($this->getContainer())
	                    	->saveUser($dto)
                    );
                }
                // if more than one user was found (usually impossible)
                if ($users->size() > 1) {
                    throw new Exception(
                        'Found more than one user with the given username'
                    );
                }
                // return the authentication result for a successfull auth process
                return new Zend_Auth_Result(
                    $result->getCode(), 
                    $user, 
                    $result->getMessages()
                );
            }
            // return the authentication result for a invalid auth process
            return $result;
        } catch(Exception $e) {
            // throw a new Exception
            throw new Zend_Auth_Adapter_Exception(
                $e->__toString()
            );
        }
    }
}