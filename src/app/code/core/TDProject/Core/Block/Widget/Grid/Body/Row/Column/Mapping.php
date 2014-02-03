<?php

/**
 * TDProject_Core_Block_Widget_Grid_Body_Row_Column_Action
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column/Mapping.php';

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

class TDProject_Core_Block_Widget_Grid_Body_Row_Column_Mapping
    extends TDProject_Core_Block_Widget_Grid_Body_Row_Column
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Mapping {
    	
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(
    	TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row $row, 
    	TDProject_Core_Interfaces_Block_Widget_Grid_Column_Mapping $column) {
        // call the parent constructor
        parent::__construct($row, $column);
    }
    
    public function prepareLayout() {
    	
    	$this->addBlock(new TDProject_Core_Block_Widget_Grid_Body_Row_Column_Value($this));
    	
    	return parent::prepareLayout();
    }
    
    protected function _resolve($value) {
    	
    	$collection = $this->_getColumn()->getCollection();
    	
    	if ($collection->size() == 0) {
    		$this->_getLogger()->warning('Found empty target Collection to map property ' . $this->_getProperty(), __LINE__);
    	}
    	
    	foreach ($collection as $data) {
    		
    		$reflectionObject = new ReflectionObject($data);
    		
    		if ($reflectionObject->hasMethod($this->_getMethodName($this->_getColumn()->getTargetProperty()))) {    			
    			
		    	$targetMethod = $reflectionObject->getMethod($this->_getMethodName($this->_getColumn()->getTargetProperty()));
    			
    			if ($targetMethod->invoke($data) == $value) {
    		
		    		if ($reflectionObject->hasMethod($this->_getMethodName($this->_getColumn()->getLabelProperty()))) {    			
		    			
				    	return $reflectionObject->getMethod($this->_getMethodName($this->_getColumn()->getLabelProperty()))->invoke($data);
				    	
		    		} else {
		    			throw new Exception('Invalid labelProperty ' . $this->_getColumn()->getLabelProperty() . ' specified');
		    		}
		    			
    			}
    		} else {
		    	throw new Exception('Invalid targetProperty ' . $this->_getColumn()->getTargetProperty() . ' specified');
    		}
    	}
    }
    
    protected function _getMethodName($property) {
	    return $targetMethodName = 'get' . ucfirst($property);
    }
    	
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column::getValue()
     */
    public function getValue() {
	    // initialize the reflection object for the class itself
	    $reflectionObject = new ReflectionObject($data = $this->_getRow()->getData());
    	// concatenate the method name
	    $methodName = 'get' . ucfirst($property = $this->_getProperty());
	    // check if a method exists to load the value for the requested property
	    if ($reflectionObject->hasMethod($methodName)) {
		    $reflectionMethod = $reflectionObject->getMethod($methodName);
		    return $this->_resolve($reflectionMethod->invoke($data));
		}
		// throw an exception if no getter for the requested property exists
		throw new Exception('No getter method for requested property ' . $property . ' available');    	
    }
}