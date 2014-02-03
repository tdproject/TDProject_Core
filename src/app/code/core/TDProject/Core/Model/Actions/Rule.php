<?php

/**
 * TDProject_Core_Model_Actions_Rule
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/Object.php';
require_once 'TechDivision/Lang/Integer.php';
require_once 'TDProject/Core/Common/ValueObjects/System/UserValue.php';
require_once 'TDProject/Core/Model/Utils/RuleUtil.php';
require_once 'TDProject/Project/Model/Utils/ProjectUtil.php';
require_once 'TDProject/Project/Model/Entities/Project.php';
require_once 'TDProject/Core/Common/ValueObjects/Collections/Privilege.php';
require_once 'TDProject/Core/Common/Interfaces/Assertion.php';

/**
 * @category   	TDProject
 * @package    	TDProject_Core
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Model_Actions_Rule
    extends TDProject_Core_Model_Actions_Abstract {

    /**
     * The available default privileges.
     * @var array
     */
    protected $_defaultPrivileges = array(
        '__default', 'create', 'edit', 'delete', 'save'
    );
    
    /**
     * Collection containing the privileges to create the rule.
     * @var TDProject_Core_Common_ValueObjects_Collections_Privilege
     */
    protected $_privileges = null;
    
    /**
     * The ACL resource to create the rule for.
     * @var Zend_Acl_Resource_Interface
     */
    protected $_resource = null;
    
    /**
     * The ACL role to create the rule for.
     * @var Zend_Acl_Role_Interface
     */
    protected $_role = null;
    
    /**
     * The assertion when creating the rule.
     * @var TDProject_Core_Common_Interfaces_Assertion
     */
    protected $_assertion = null;

    /**
     * Protected constructor to prevent class
     * from direct instanciation.
	 *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
	 * @return void
     */
    public function __construct(TechDivision_Model_Interfaces_Container $container)
    {
        // pass the container to the parent class
        parent::__construct($container);
        // initialize and return the default privilege set
	    $this->_privileges =
	        new TDProject_Core_Common_ValueObjects_Collections_Privilege();
        // attach the privileges
	    foreach ($this->_defaultPrivileges as $privilege) {
	        $this->_privileges->addPrivilege($privilege);
	    }
    }

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Actions_Rule($container);
    }

    /**
     * Creates a rule for the passed resource/user/role/privilege
     * combination that gives the user access to the resource.
     *
     * @param Zend_Acl_Resource_Interface $resource The resource to allow
     * @param Zend_Acl_Role_Interface $role The role to allow
     * @param TDProject_Core_Common_ValueObjects_Collections_Privilege $privileges
     * 		The privileges of the resource to allow for the passed role
     * @param TDProject_Core_Common_Interfaces_Assertion $assertion
     * 		The assertion
     */
	protected function _allow(
	    Zend_Acl_Resource_Interface $resource,
	    Zend_Acl_Role_Interface $role,
	    TDProject_Core_Common_ValueObjects_Collections_Privilege $privileges = null,
	    TDProject_Core_Common_Interfaces_Assertion $assertion = null) {
	    // initialize new rule
        $rule = TDProject_Core_Model_Utils_RuleUtil::getHome($this->getContainer())
            ->epbCreate();
        // save the rule
        $rule->setRoleIdFk($role->getRoleId());
        // check if an Assertion is available
        if ($assertion != null) {
            $rule->setAssertionIdFk($assertion->getAssertionId());
        } else {
            $rule->setAssertionIdFk(null);
        }
        // check if privileges was passed
        if ($privileges != null) {
            $rule->setPrivileges($privileges->toString());
        } else {
            $rule->setPrivileges(null);
        }
        // set the resource
        $rule->setResource(
            new TechDivision_Lang_String(
                $resource->getResourceId()
            )
        );
        // set the permissions and create the rule finally
        $rule->setPermission(new TechDivision_Lang_String('allow'));
        $rule->create();
        // load the container and remove the ACL's from the cache
        $this->getContainer()->getCache()->remove(TDProject_Core_Model_Actions_Acl::CACHE_KEY);
	}

    /**
     * Creates a rule for the passed resource/user/role/privilege
     * combination that gives the user full access to the resource.
     *
     * @param Zend_Acl_Resource_Interface $resource The resource to allow
     * @param Zend_Acl_Role_Interface $role The role to allow
     * @param TDProject_Core_Common_Interfaces_Assertion $assertion
     * 		The assertion
     * @see TDProject/Core/Model/Actions/Rule::allow()
     */
    public function allow() {
        // create a new ruleset with full access
        $this->_allow(
            $this->getResource(), 
            $this->getRole(), 
            $this->getPrivileges(), 
            $this->getAssertion()
        );
    }
    
    /**
     * Adds the resource to create the ACL rule for.
     * 
     * @param Zend_Acl_Resource_Interface $resource
     * 		The ACL resource to create the rule for
     * @return TDProject_Core_Model_Actions_Rule
     * 		The rule instance itself
     */
    public function setResource(Zend_Acl_Resource_Interface $resource)
    {
        $this->_resource = $resource;
        return $this;
    }
    
    /**
     * Returns the resource to create the ACL rule for.
     * 
     * @return Zend_Acl_Resource_Interface
     * 		he ACL resource to create the rule for
     */
    public function getResource()
    {
        return $this->_resource;
    }
    
    /**
     * Adds the role to create the ACL rule for.
     * 
     * @param Zend_Acl_Role_Interface $role
     * 		The ACL role to create the rule for
     * @return TDProject_Core_Model_Actions_Rule
     * 		The rule instance itself
     */
    public function setRole(Zend_Acl_Role_Interface $role)
    {
        $this->_role = $role;
        return $this;
    }
    
    /**
     * Returns the role to create the ACL rule for.
     * 
     * @return Zend_Acl_Role_Interface
     * 		The ACL role to create the rule for
     */
    public function getRole()
    {
        return $this->_role;
    }
    
    /**
     * Adds the assertion to create the ACL rule.
     * 
     * @param TDProject_Core_Common_Interfaces_Assertion $role
     * 		The assertion to create the rule
     * @return TDProject_Core_Model_Actions_Rule
     * 		The rule instance itself
     */
    public function setAssertion(
        TDProject_Core_Common_Interfaces_Assertion $assertion) {
        $this->_assertion = $assertion;
        return $this;
    }
    
    /**
     * Returns the assertion to create the ACL rule.
     * 
     * @return TDProject_Core_Common_Interfaces_Assertion
     * 		The assertion itself
     */
    public function getAssertion()
    {
        return $this->_assertion;
    }

    /**
     * Returns a Collection with all available privileges.
     *
     * @return TDProject_Core_Common_ValueObjects_Collections_Privilege
     * 		Collection with all available privileges
     */
    public function getPrivileges()
    {
	    return $this->_privileges;
    }
}