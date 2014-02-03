<?php

/**
 * TDProject_Core_Model_Actions_Acl
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
class TDProject_Core_Model_Actions_Acl
    extends TDProject_Core_Model_Actions_Abstract {

    /**
     * The cache key prefix.
     * @var string
     */
    const CACHE_KEY = 'tdproject_core_model_actions_acls';

    /**
     * Factory method to create a new instance.
     *
     * @param TechDivision_Model_Interfaces_Container $container The container instance
     * @return TDProject_Channel_Model_Actions_Category
     * 		The requested instance
     */
    public static function create(TechDivision_Model_Interfaces_Container $container)
    {
        return new TDProject_Core_Model_Actions_Acl($container);
    }
    
    /**
     * Returns the initialized ACL.
     * 
     * @return Zend_Acl The initialized ACL
     */
    public function getAcl()
    {        
        // instanciate the ACL
        $acl = new Zend_Acl();        
        // load the availble roles
        $systemRoles = TDProject_Core_Model_Utils_RoleUtil::getHome($this->getContainer())
            ->findAll();
        // load the system roles
        foreach ($systemRoles as $systemRole) {
            $this->_loadRole($acl, $systemRole);
        }
	    // initialize the API
	    $api = new TDProject_Core_Common_Api();
	    $api->parse();
        // initialze the XPath expression
        $xPath = new DOMXPath($api);
        // load the DOMNodeList with the resources by a XPath query
        $resources = $xPath->query("/resources/resource/@name");
        // iterate recursively over the found resources
		$this->_processFile($acl, $api, $resources);
		$this->_processDatabase($acl);
		// return the initialized ACL
		return $acl;
    }

    /**
     * Recursively Appends the passed role and the parent roles
     * to the ACL tree.
     *
     * @param Zend_Acl $acl The ACL to append the role to
     * @param TDProject_Core_Model_Entities_Role $role
     * 		The role to append
     */
    protected function _loadRole(
        Zend_Acl $acl,
        TDProject_Core_Model_Entities_Role $role) {
        // initialize the parent role
        $aclParent = null;
        // check if a parent exists
        if ($role->getParent()) {
            // if yes append the parent first, to inherit the rights
            $aclParent = $this->_loadRole($acl, $role->getParent());
        }
        // check if the role already exists, if yes, return it
        if ($acl->hasRole($role->getName())) {
            return $acl->getRole($role->getName());
        }
        // if not, create a new ACL role
        $aclRole = new Zend_Acl_Role($role->getName());
        // add the role to the ACL tree
        $acl->addRole($aclRole, $aclParent);
        // return the created role
        return $aclRole;
    }

    /**
     * Processes the database ACL's.
     *
     * @param Zend_Acl $acl The ACL to process the database resources for
     * @return void
     */
    protected function _processDatabase(Zend_Acl $acl)
    {
        // load rules from the database
        $rules = TDProject_Core_Model_Utils_RuleUtil::getHome($this->getContainer())
            ->findAll();
        // iterate over all rules and load the ACL's
        foreach ($rules as $rule) {
            // add the resource
            $this->_addResource(
                $acl,
                $aclResource = new Zend_Acl_Resource(
                    $rule->getResource()->__toString()
                )
            );
            // initialize the Assertion
            $assertion = null;
            // check if an Assertion is requested
            if ($rule->getAssertion() != null) {
                require_once $rule->getAssertion()->getInclude();
                // reflect the Assertion class
                $reflectionClass =
                    new ReflectionClass($rule->getAssertion()->getType());
                // create a new instance of the Assertion
                $assertion = $reflectionClass->newInstance();
            }
            // initialize the found role
            $role = new Zend_Acl_Role(
                $rule->getRole()->getName()->__toString()
            );
            // allow/deny the role for the found resource
            $reflectionObject = new ReflectionObject($acl);
            $methodName = $rule->getPermission();
            if ($reflectionObject->hasMethod($methodName)) {
                $reflectionMethod = $reflectionObject->getMethod($methodName);
                $reflectionMethod->invoke(
                    $acl,
                    $role,
                    $aclResource,
                    explode(',', $rule->getPrivileges()->__toString()),
                    $assertion
                );
            }
        }
    }

    /**
     * Processes a given DOMNodeList of ACL resources recursively
     *
     * @param Zend_Acl $acl The ACL to process the resources for
     * @param DOMNodeList $resources The DOMNodeList to process
     * @param string $prefix 
     * 		The prefix to add before the xPath query (either the xml root 
     *  	element or the parent element of the processed children tree)
     * @return void
     */
    protected function _processFile(
        Zend_Acl $acl,
        TDProject_Core_Common_Api $api,
        DOMNodeList $resources, 
        $prefix="/resources") {
    	// initialize the XPath expression
        $xPath = new DOMXPath($api);
    	// iterate over the available resource
        foreach ($resources as $resource) {
            // load the resource name
            $r = $resource->nodeValue;
            // load the resource methods
            $methods = $xPath->query(
                "$prefix/resource[@name='$r']/methods/method/@name"
            );
            //  if the current resource has child resources,
            // these are recursively processed here
            $children = $xPath->query(
                "$prefix/resource[@name='$r']/children/resource/@name"
            );
            // if children was found, process them first
            if ($children->length > 0) {
            	$this->_processFile(
            	    $acl, $api, $children, "/resources/resource[@name='$r']/children"
            	);
            }
            // add the resource
            $this->_addResource(
                $acl, $aclResource = new Zend_Acl_Resource($r)
            );
            // iterate over the found methods
            foreach ($methods as $method) {
                // load the resource's method name
                $m = (string) $method->nodeValue;
                // load the roles the resources is available for
                $roles = $xPath->query(
                	"$prefix/resource[@name='$r']/methods/method[@name='$m']/roles/role/@name"
                );
                // set the role for the resource
                foreach ($roles as $role) {
                    $aclRole = new Zend_Acl_Role((string) $role->nodeValue);
                    $acl->allow($aclRole, $aclResource, $m);
                }
            }
        }
    }

    /**
     * Add the passed resource to the ACL's.
     *
     * @param Zend_Acl $acl The ACL to add the resource to
     * @param Zend_Acl_Resource $resource The resource to add
     * @return TDProject_Core_Model_Actions_Acl
     * 		The instance itself
     */
    protected function _addResource(Zend_Acl $acl, Zend_Acl_Resource $resource)
    {
        // check if the resource already is registered
        if ($acl->has($resource) === false) {
            // if not, add the resource
            $acl->addResource($resource);
        }
        return $this;
    }
}