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
require_once 'TDProject/Core/Interfaces/Block/Widget/Grid/Body/Row/Column/Actions/Action.php';

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

class TDProject_Core_Block_Widget_Grid_Body_Row_Column_Actions_View
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column_Actions_Action {   
    	
    const BLOCK_NAME = 'view';
    
    /**
     * The row with the data to render the column for.
     * @var TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column
     */
    protected $_parent = null;
    
    protected $_property = '';
    
    /**
     * Initialize the block with the
     * apropriate template and name.
     * 
     * @return void
     */
    public function __construct(
    	TDProject_Core_Interfaces_Block_Widget_Grid_Body_Row_Column $parent, 
    	TDProject_Core_Interfaces_Block_Widget_Grid_Column_Action $action) {
        // call the parent constructor
        parent::__construct($parent->getContext());
        // set the grid the column is bound to
        $this->_parent = $parent;
        // sets the block name and title
        $this->_setBlockName(TDProject_Core_Block_Widget_Grid_Body_Row_Column_Actions_View::BLOCK_NAME);
        $this->_setBlockTitle($action->getLabel());
        $this->_setProperty($action->getProperty());
        $this->_setUrl($action->getUrl());
        // set the template name
        $this->_setTemplate('www/design/core/templates/widget/grid/body/row/column/actions/view.phtml'); 
    }
    
    public function getOnSelect() {
    	return $this->_getUrl() . '&' . $this->_getProperty() . '=' . $this->_getValue();
    }
    
    protected function _setUrl($url) {
    	$this->_url = $url;
    }
    
    protected function _getUrl() {
    	return $this->_url;
    }
    
    protected function _setProperty($property) {
    	$this->_property = $property;
    }
    
    protected function _getProperty() {
    	return $this->_property;
    }
    
    protected function _getParent() {
    	return $this->_parent;
    }
    
    protected function _getValue() {
	    // initialize the reflection object for the class itself
	    $reflectionObject = new ReflectionObject($data = $this->_getParent()->getData());
    	// concatenate the method name
	    $methodName = 'get' . ucfirst($property = $this->_getProperty());
	    // check if a method exists to load the value for the requested property
	    if ($reflectionObject->hasMethod($methodName)) {
		    $reflectionMethod = $reflectionObject->getMethod($methodName);
		    return $reflectionMethod->invoke($data);
		}
		// throw an exception if no getter for the requested property exists
		throw new Exception('No getter method for requested property ' . $property . ' available');    	
    }
}