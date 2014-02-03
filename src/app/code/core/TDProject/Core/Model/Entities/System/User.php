<?php

/**
 * TDProject_Core_Model_Entities_System_User
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Entity for handling the system user.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Entities_System_User
    extends TDProject_Core_Model_Entities_User {

    /**
     * The ACL's.
     * @var Zend_Acl
     */
    protected $_acl = null;

    /**
     * The Zend_Auth Adapters used for authentication.
     * @var array
     */
    protected $_adapters = array();

    /**
     * DOMDocument with the navigation.xml's of all packages.
     * @var TechDivision_Core_Common_Navigation
     */
    protected $_navigation = null;

    /**
     * Array with the IDs of the initialized roles.
     * @var array
     */
    protected $_roles = array();

    /**
     * (non-PHPdoc)
     * @see TechDivision_Model_Interfaces_Entity::disconnect()
     */
	public function disconnect()
	{
	    parent::disconnect();
	    $this->_navigation = null;
	}

    /**
     * (non-PHPdoc)
     * @see TechDivision_Model_Interfaces_Entity::connect()
     */
    public function connect(
        TechDivision_Model_Interfaces_Container $container)
    {
        // initialize the navigation
	    $this->_navigation = new TDProject_Core_Common_Navigation();
	    $this->_navigation->parse();
        return parent::connect($container);
    }

    /**
     * Returns the logger instance.
     *
     * @return TechDivision_Logger_Interfaces_Logger The instance
     */
    public static function _getLogger()
    {
        return TechDivision_Logger_Logger::forClass(
            __CLASS__,
            'TDProject/META-INF/log4php.properties'
        );
    }

    /**
     * (non-PHPdoc)
     * @see TechDivision_Model_Interfaces_Entity::getEntityAlias()
     */
    public function getEntityAlias()
    {
        return 'TDProject_Core_Model_Entities_System_User';
    }

    /**
     * Checks if the user is allowed to user the passed
     * resource and returns TRUE if yes, else FALSE.
	 *
     * @param string $resource The resource to check
     * @param string $privilege The privilege to check
     * @return boolean
     * 		TRUE if the users is allowed to use the resource, else FALSE
     */
    public function isAllowed($resource = null, $privilege = null)
    {
        // check if the user is allowed to access the passed resource
        foreach ($this->getUserRoles() as $role) {
            $aclRole = new Zend_Acl_Role($role->getName()->__toString());
            if ($this->getAcl()->isAllowed($aclRole, $resource, $privilege)) {
                return true;
            }
        }
        // return FALSE if not
        return false;
    }

    /**
     * Add the ACL's to the user.
     *
     * @param Zend_Acl $acl The ACL's to add
     */
    public function setAcl(Zend_Acl $acl)
    {
        $this->_acl = $acl;
        return $this;
    }

    /**
     * Returns the available ACL's.
     *
     * @return Zend_Acl
     */
    public function getAcl()
    {
        return $this->_acl;
    }

    /**
     * Returns the Navigation structure of all packages.
     *
     * @return TDProject_Core_Common_Navigation
     * 		The Navigation structure
     */
    public function getNavigation()
    {
        return $this->_navigation;
    }

    /**
     * Returns the TDProject_Core_Common_ValueObjects_System_UserValue object.
     *
     * @param boolean $refresh Holds the flag to identified, that the data should be refreshed from the database
     * @return TDProject_Core_Common_ValueObjects_System_UserValue Holds the Value object with the data
     */
    public function getValue()
    {
        return new TDProject_Core_Common_ValueObjects_System_UserValue($this);
    }

    /**
     * Initializes the Zend_Auth LDAP Adapter for authentication
     * againts the LDAP directory specified in the configuration.
     *
     * @return void
     * @todo Load options from configuration/database
     */
    protected function _getLdapAdapter()
    {
        // initialize a new LocalHome
	    $home = TDProject_Core_Model_Utils_SettingUtil::getHome($this->getContainer());
	    // load the settings if available
	    $settings = $home->findAll();
	    // iterate over the settings and return the first one
	    for($i = 0; $i < $settings->size(); $i++) {
	        // load the setting
	        $setting = $settings->get($i);
            // check if LDAP has to be used
	        if ($setting->getUseLdap()->booleanValue()) {
                // initialize the options
                $options = array(
                    'td' => array(
                        'host'              =>
                            $setting->getLdapHost()->stringValue(),
                        'accountDomainName' =>
                            $setting->getLdapDomain()->stringValue(),
                        'baseDn'            =>
                            $setting->getLdapDn()->stringValue(),
                        'bindRequiresDn'    =>
                            $setting->getLdapBindRequired()->booleanValue()
                    )
                );
                // initialize the Adapter
                $adapter = new TDProject_Core_Model_Auth_Adapter_Ldap(
                    $options,
                    $this->getUsername()->stringValue(),
                    $this->getPassword()->stringValue()
                );
                // add it to the internal array
                $this->_adapters[] = $adapter->setContainer($this->getContainer());
	        }
	    }
    }

    /**
     * Initializes the Zend_Auth database Adapter for authentication
     * againts the database specified in the configuration.
     *
     * @return void
     */
    protected function _getDatabaseAdapter()
    {
        // initialize the Adapter
        $adapter = new TDProject_Core_Model_Auth_Adapter_Database(
            $this->getUsername(),
            $this->getPassword()
        );
        // add it to the internal array
        $this->_adapters[] = $adapter->setContainer($this->getContainer());
    }

    /**
     * Checks the username and password set in the
     * instance and loads the user, if valid.
     *
     * @param TechDivision_Model_Interfaces_Container The container instance
     * @throws TDProject_Core_Common_Exceptions_InvalidUsernameException
     * 		Is thrown if username is not unique or can't be found
     * @throws TDProject_Core_Common_Exceptions_InvalidPasswordException
     * 		Is thrown if password is not valid
     * @throws Zend_Auth_Exception
     * 		Is thrown authentication process can't be executed
     * @return void
     */
    public function authenticate(TechDivision_Model_Interfaces_Container $container)
    {
        // initialize the Zend_Auth instance
        $auth = Zend_Auth::getInstance();
        // set the storage to a non persistent instance, because
        // the system user is storend in the web session
        $auth->setStorage(
            new Zend_Auth_Storage_NonPersistent()
        );
        // initialize the authentication Adapters
        $this->_getLdapAdapter($container);
        $this->_getDatabaseAdapter($container);
        // execute one Adapter after another and try to authenticate
        for ($i = 0; $i < sizeof($this->_adapters); $i++) {
            try {
                // run authentication with the found Adapter
                $result = $auth->authenticate($this->_adapters[$i]);
                // log the results
                foreach ($result->getMessages() as $message) {
                    $this->_getLogger()->error($message, __LINE__);
                }
                // check the result of the Adapter's authentication method
                if ($result->getCode() === Zend_Auth_Result::SUCCESS) {
                    // log a successfull authentication process
                    self::_getLogger()->error(
                    	"SUCCESS: authenticated " . $this->getUsername()->stringValue() . "\n",
                        __LINE__
                    );
                    // load the system user data
                    $this->load(
                        $result->getIdentity()->getPrimaryKey()
                    );
                    // return if authentication was successfull
                    return;
                }
            }
            // catch the authentication exception 
            catch (Zend_Auth_Adapter_Exception $zaae) {
                // log the exception
                self::_getLogger()->error($zaae->__toString());
                // initialize a new Zend_Auth_Result instance
				// load the message
                $message = $zaae->getMessage();
				// check if the message is an array
                if(!is_array($message)) {
                	$message = array($message);
                }
				// initialize the authentication result
                $result = new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE,
                    $this,
                    $message
                );
                // continue with the next Adapter
                continue;
            }
        }
        // if authentication can't be validated, throw an apropriate exception
        switch ($result->getCode()) {
            // if no user with the passed username could be found
            case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                throw new TDProject_Core_Common_Exceptions_InvalidUsernameException(
             		'Invalid username ' . $this->getUsername()
                 );
                 break;
            // if more than ONE user was found (usually not possible)
            case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
                throw new TDProject_Core_Common_Exceptions_InvalidUsernameException(
             		'Ambigous username ' . $this->getUsername()
                 );
                 break;
            // if username and password doesn't match
            case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
            	throw new TDProject_Core_Common_Exceptions_InvalidPasswordException(
                	'Invalid password'
                );
                break;
            // for all other failures
            default:
                throw new Zend_Auth_Exception(
                    implode('; ', $result->getMessages()),
                    $result->getCode()
                );
        }
    }

    /**
     * Returns the parent role of the first
     * user role found.
     *
     * @return TDProject_Core_Model_Entities_Role
     * 		The system user's default role
     */
    public function getDefaultRole()
    {
        // return the first parent role
        foreach ($this->getUserRoles() as $role) {
            return $role->getParent();
        }
    }
}