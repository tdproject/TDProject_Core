<?php

/**
 * TDProject_Core_Model_Auth_Adapter_Database
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'Zend/Auth/Adapter/Interface.php';
require_once 'Zend/Auth/Adapter/Exception.php';

/**
 * Zend_Auth Adapter for database authentication
 * against the database defined in the project
 * configuration.
 *
 * @package Model
 * @author Tim Wagner <tw@techdivision.com>
 * @version $Revision: 1.1 $ $Date: 2007-10-25 16:09:14 $
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 */
class TDProject_Core_Model_Auth_Adapter_Database
    extends TechDivision_Lang_Object
    implements Zend_Auth_Adapter_Interface {

    /**
     * The username used for authentication.
     * @var TechDivision_Lang_String
     */
    protected $_username = null;

    /**
     * The password used for authentication.
     * @var TechDivision_Lang_String
     */
    protected $_password = null;
    
    /**
     * The container instance.
     * @var TechDivision_Model_Interfaces_Container
     */
    protected $_container = null;

    /**
     * Initializes the Adapter with the passed
     * username and password.
     *
     * @param TechDivision_Lang_String $username
     * 		The username used for authentication
     * @param TechDivision_Lang_String $password
     * 		The password used for authentication
     * @return void
     */
    public function __construct(
        TechDivision_Lang_String $username,
        TechDivision_Lang_String $password) {
        // initialize the members
        $this->_username = $username;
        $this->_password = $password;
    }
    
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
     * @see Zend/Auth/Adapter/Zend_Auth_Adapter_Interface::authenticate()
     */
    public function authenticate()
    {
        try {
            // load the user by it's email
            $users = TDProject_Core_Model_Utils_System_UserUtil::getHome($this->getContainer())
                ->findAllByUsername($this->_username);
            // if no user can be found
            if ($users->size() === 0) {
                // return the authentication result for
                // an unknown username
                return new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
                    $this->_username,
                    array(
                    	'Invalid username ' . $this->_username
                    )
                );
            }
            // if more than one user was found (usually impossible)
            if ($users->size() > 1) {
                // return the authentication result for an
                // ambigous username
                return new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS,
                    $user,
                    array(
                        'Ambigous username ' . $this->_username
                    )
                );
            }
            // load the found user and update the LDAP synced flag
            $user = $users->get($users->size() - 1);
            $user->setLdapSynced(new TechDivision_Lang_Boolean(false));
            $user->update();
            // check the users password
            if (!$user->getPassword()->equals($this->_password->md5())) {
                // return the authentication result for a
                // invalid password
                return new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                    $user,
                    array(
                        'Invalid password'
                    )
                );
            }
            // return the authentication result for a
            // successfull authentication process
            return new Zend_Auth_Result(
                Zend_Auth_Result::SUCCESS,
                $user,
                array()
            );
        } catch(Exception $e) {
            // throw a new Exception
            throw new Zend_Auth_Adapter_Exception(
                $e->__toString()
            );
        }
    }
}