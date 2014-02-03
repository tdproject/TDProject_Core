<?php

/**
 * TDProject_Core_Block_Widget_View
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

require_once 'TDProject/Core/Block/Widget/Abstract.php';
require_once 'TDProject/Core/Interfaces/Block/Widget/Form.php';
require_once 'TDProject/Core/Block/Widget/Toolbar.php';
require_once 'TDProject/Core/Block/Widget/Tabs.php';
require_once 'TDProject/Core/Block/Widget/Button/Back.php';
require_once 'TDProject/Core/Block/Widget/Button/Save.php';
require_once 'TDProject/Core/Block/Widget/Button/Delete.php';
require_once 'TDProject/Core/Block/Widget/Element/Input/Textfield.php';
require_once 'TDProject/Core/Block/Widget/Element/Input/Password.php';
require_once 'TDProject/Core/Block/Widget/Element/Input/Checkbox.php';
require_once 'TDProject/Core/Block/Widget/Element/Input/Hidden.php';
require_once 'TDProject/Core/Block/Widget/Element/Select.php';

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

abstract class TDProject_Core_Block_Widget_Form_Abstract 
    extends TDProject_Core_Block_Widget_Abstract
    implements TDProject_Core_Interfaces_Block_Widget_Form {
    
		
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Form::getFormName()
	 */
	public function getFormName() {
		return $this->getContext()->getActionMapping()->getName();
	}

	/**
     * (non-PHPdoc)
     * @see TDProject/Interfaces/Block#prepareLayout()
     */
    public function prepareLayout() {
        // return a reference to the block itself
        return parent::prepareLayout();
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Form::getValueByProperty()
     */
    public function getValueByProperty($property) {
	    // initialize the reflection object for the class itself
	    $reflectionObject = new ReflectionObject($this);
    	// concatenate the method name
	    $methodName = 'get' . ucfirst($property);
	    // check if a method exists to load the value for the requested property
	    if ($reflectionObject->hasMethod($methodName)) {
		    $reflectionMethod = $reflectionObject->getMethod($methodName);
		    return $reflectionMethod->invoke($this);
		}
		// throw an exception if no getter for the requested property exists
		throw new Exception('No getter method for requested property ' . $property . ' available');
    }
    
    /**
     * Adds the passed tab to the view.
     * 
     * @param TDProject_Core_Interfaces_Block_Widget_Tab $tab
     * 		The tab to add
     * @return TDProject_Core_Interfaces_Block_Widget_Tab
     * 		The tab instance itself
     */
    protected function _addTabs(
        TDProject_Core_Interfaces_Block_Widget_Tabs $tabs) {
    	$this->addBlock($tabs);
    	return $tabs;
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form::addTabs()
     */
    public function addTabs($blockName, $blockTitle) {
    	return $this->_addTabs(
    		new TDProject_Core_Block_Widget_Tabs(
    		    $this->getContext(), 
    		    $blockName, 
    		    $blockTitle
    		)
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form::hasToolbar()
     */
    public function hasToolbar() {
    	return array_key_exists(
    	    TDProject_Core_Block_Widget_Toolbar::BLOCK_NAME, $this->_childs
    	);
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form::getToolbar()
     */
    public function getToolbar() {
    	// check if a toolbar was already initialized
    	if (!$this->hasToolbar()) {
	        // if not, prepare the toolbar widget
			$this->addBlock(new TDProject_Core_Block_Widget_Toolbar($this->getContext()));
    	}
    	// return the toolbar
    	return $this->_getBlock(TDProject_Core_Block_Widget_Toolbar::BLOCK_NAME);
    }
    
    /**
     * (non-PHPdoc)
     * @see TDProject_Core_Interfaces_Block_Widget_Form::getPathPrepared($prepareWith)
     */
    public function getPathPrepared($prepareWith = '.') {
    	return new TechDivision_Lang_String(str_replace('/', $prepareWith, $this->getPath()));
    }
    
	/**
	 * (non-PHPdoc)
	 * @see TDProject_Core_Interfaces_Block_Widget_Form::getPath()
	 */
	public function getPath() {
		return new TechDivision_Lang_String(
			$this->getContext()->getActionMapping()->getPath()
		);
	}
}