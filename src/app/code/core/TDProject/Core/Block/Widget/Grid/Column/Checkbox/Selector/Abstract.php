<?php

/**
 * TDProject_Core_Block_Widget_Grid_Column_Action
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Checkbox.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column/Checkbox/Selector.php';

/**
 * This class implements the form functionality
 * for handling the application settings.
 *
 * @category    TProject
 * @package     TDProject_Core
 * @copyright   Copyright (c) 2010 <info@techdivision.com> - TechDivision GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php
 *              Open Software License (OSL 3.0)
 * @author      Bastian Stangl <b.stangl@techdivision.com>
 */
abstract class TDProject_Core_Block_Widget_Grid_Column_Checkbox_Selector_Abstract
	implements TDProject_Core_Interfaces_Block_Widget_Grid_Column_Checkbox_Selector {
	
	protected $_column = null;
	
	protected $_sourceProperty = '';
	
	protected $_targetProperty = '';
	
	public function __construct(TDProject_Core_Interfaces_Block_Widget_Grid_Column_Checkbox $column) {
		$this->_column = $column;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Checkbox_Selector::getColumn()
	 */
	public function getColumn() {
		return $this->_column;
	}
	
	public function setTargetProperty($targetProperty) {
		$this->_targetProperty = $targetProperty;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Grid_Column_Checkbox_Selector::getTargetProperty()
	 */
	public function getTargetProperty() {
		return $this->_targetProperty;
	}
    
    public function getValue(TechDivision_Lang_Object $object) {
    	return $this->_invoke($object, $this->getColumn()->getProperty());
    }
   	
   	protected function _invoke($instance, $property) {
	    // initialize the reflection object for the class itself
    	$reflectionObject = new ReflectionObject($instance);
    	// concatenate the method name
	    $methodName = 'get' . ucfirst($property);
	    // check if a method exists to load the value for the requested property
	    if ($reflectionObject->hasMethod($methodName)) {
	    	return $reflectionObject->getMethod($methodName)->invoke($instance);
	    }
		// throw an exception if no getter for the requested property exists
		throw new Exception('Requested getter for property ' . $property . ' for object ' . get_class($instance)  . ' not available'); 
   	}
}