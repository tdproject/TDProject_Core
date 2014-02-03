<?php

/**
 * TDProject_Core_Common_ValueObjects_UserViewData
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TechDivision/Lang/String.php';
require_once 'TDProject/Core/Common/Interfaces/Assertion.php';
require_once 'TDProject/Core/Common/ValueObjects/AssertionLightValue.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Element/Select/Option.php';

/**
 * This class is the data transfer object between the
 * model and the controller for the table assertion.
 *
 * Each class member reflects a database field and
 * the values of the related dataset.
 *
 * @category   	TDProject
 * @package     TDProject_ERP
 * @copyright  	Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license    	http://opensource.org/licenses/osl-3.0.php
 * 				Open Software License (OSL 3.0)
 * @author      Tim Wagner <tw@techdivision.com>
 */
class TDProject_Core_Common_ValueObjects_AssertionOverviewData
    extends TDProject_Core_Common_ValueObjects_AssertionLightValue
    implements TDProject_Core_Interfaces_Block_Widget_Element_Select_Option,
        TDProject_Core_Common_Interfaces_Assertion {

	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionValue()
	 */
   	public function getOptionValue()
   	{
   		return $this->getAssertionId();
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::getOptionLabel()
   	 */
   	public function getOptionLabel()
   	{
   		return $this->getType();
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Interfaces_Block_Widget_Element_Select_Option::isSelected()
   	 */
   	public function isSelected(TechDivision_Lang_Object $value = null)
   	{
   		// check if the passed value is empty
   		if ($value == null) {
   			return false;
   		}
   		// check if the user ID's equals
   		return $this->getAssertionId()->equals($value);
   	}

   	/**
   	 * (non-PHPdoc)
   	 * @see TDProject_Core_Common_Interfaces_Assertion::assert()
   	 */
    public function assert(
        Zend_Acl $acl,
        Zend_Acl_Role_Interface $role = null,
        Zend_Acl_Resource_Interface $resource = null,
        $privilege = null) {
        // include the necessary class
        require_once $this->getIncludeFile();
        // initialize an instance
        $reflectionClass = new ReflectionClass($this->getType());
        $instance = $reflectionClass->newInstance();
        // check if the class implements the necessary interface
        if ($reflectionClass->implementsInterface(Zend_Acl_Assert_Interface)) {
            // load the method
            $reflectionMethod = $instance->getMethod($instance, 'assert');
            // invoke the method with the passed parameters
            return $reflectionMethod->invoke(
                $instance, $acl, $role, $resource, $privilege
            );
        }
    }
}